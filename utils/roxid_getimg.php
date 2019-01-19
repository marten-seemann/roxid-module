<?php
// Checks if instance name getter does not exist
if ( !function_exists( "getGeneratorInstanceName" ) ) {
  /**
  * Returns image generator instance name
  *
  * @return string
  */
  function getGeneratorInstanceName() {
    return "roxiddynimggenerator";
  }
}

// use $_SERVER["SCRIPT_FILENAME"] instead of __DIR__, since __DIR__ resolves symlinks
$dirname = dirname($_SERVER["SCRIPT_FILENAME"]);
require_once $dirname . "/../../../bootstrap.php";

//* BEGIN DEV *//
// include the file from the current oxbasedir, even if the roxid_getimg.php might be symlinked
// probably only the case in dev environment
// thus removed by build script for productive environment
function canonicalize($address) {
  $address = explode('/', $address);
  $keys = array_keys($address, '..');

  foreach($keys AS $keypos => $key) {
    array_splice($address, $key - ($keypos * 2 + 1), 2);
  }

  $address = implode('/', $address);
  $address = str_replace('./', '', $address);
  return $address;
}

$dirname = canonicalize(dirname($_SERVER['SCRIPT_FILENAME']));
//* END DEV *//

$file = dirname(__FILE__)."/../../responsive_slider/utils/getimg.php";
if(file_exists($file)) {
  require(dirname(__FILE__)."/../../responsive_slider/utils/getimg.php");
}
else {
  class sliderdynimggenerator extends OxidEsales\EshopCommunity\Core\DynamicImageGenerator { }
}

class roxiddynimggenerator extends sliderdynimggenerator {
  public function outputImage() {
    foreach($this->_aConfParamToPath as $var => $value) {
      $this->_aConfParamToPath[$var."Phone"] = $value;
    }
    parent::outputImage();
  }

  public function _getImageUri() {
    $uri = parent::_getImageUri();
    $path_parts = pathinfo($uri);
    $filename = $path_parts['filename'];
    
    if(substr($filename, -3) == "@2x") {
      $ext = $path_parts['extension'];
      $path = $path_parts['dirname'];
      
      $dir = substr($path, strrpos($path, "/")+1);
      $values = explode("_", $dir);
      $quality = $values[2];
      $new_path = substr($path, 0, strrpos($path, "/")+1).(2*$values[0])."_".(2*$values[1])."_".$quality;
      $uri = $new_path."/".str_replace("@2x", "", $filename).".".$ext;
    }
    
    return $uri;
  }

  /**
  * adjust image quality for retina images
  *
  * in general, retina images can be compressed very much (by lowering the JPEG quality)
  * this function reduces the quality of the image, but only if the image generated for the retina device is actually an image with a higher resolution
  * example: if the original image has dimensions 100x100, and the (retina) image requested has dimensions 200x200, OXID will still generate a 100x100 picture. Of course, in this case the quality must not be lowered!
  */
  public function _generateImage( $sImageSource, $sImageTarget ) {
    $request_uri = parent::_getImageUri();
    // only for retina images
    if(strpos($request_uri, "@2x") !== false) {
      $source_path_parts = pathinfo($sImageSource);
      $target_path_parts = pathinfo($sImageTarget);

      $target_lastdir = substr($target_path_parts['dirname'], strrpos($target_path_parts['dirname'], "/")+1);
      $target_lastdir_parts = explode("_", $target_lastdir);
      $target_width = $target_lastdir_parts[0];
      $target_height = $target_lastdir_parts[1];
      $target_quality = $target_lastdir_parts[2];

      $source_imagesize = getimagesize($sImageSource);
      $source_width = $source_imagesize[0];

      // image quality will be reduced by $factor
      $factor = 1;
      if($source_width > $target_width) $factor = 1.75;

      $sImageTarget = substr($target_path_parts['dirname'], 0, strrpos($target_path_parts['dirname'], "/")+1) . $target_width . "_" . $target_height . "_" . intval($target_quality / $factor)."/". $target_path_parts['basename'];

      $path = parent::_generateImage($sImageSource, $sImageTarget);
      $new_path = parent::_getShopBasePath().parent::_getImageUri();
      if(!is_dir(dirname($new_path))) mkdir(dirname($new_path));
      rename($path, $new_path);
      return $new_path;
    } else {
      return parent::_generateImage($sImageSource,$sImageTarget);
    }
  }

    /**
   * Checks if main folder matches requested
   *
   * @param string $path image path name to check
   *
   * @return bool
   */
  protected function _isValidPath($path) {
    $valid = false;

    list($width, $height, $quality) = $this->_getImageInfo();
    if ($width && $height && $quality) {
      $config = \OxidEsales\Eshop\Core\Registry::getConfig();
      $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);

      // parameter names
      $names = [];
      foreach ($this->_aConfParamToPath as $paramName => $pathReg) {
        if (preg_match($pathReg, $path)) {
          $names[] = $db->quote($paramName);
          if ($paramName == "sManufacturerIconsize" || $paramName == "sCatIconsize") {
            $names[] = $db->quote("sIconsize");
          }
        }
      }
      $names = implode(', ', $names);

      // any name matching path?
      if ($names) {
        $decodeField = $config->getDecodeValueQuery();

        // selecting shop which image quality matches user given
        $q = "select oxshopid from oxconfig where (oxvarname = 'sDefaultImageQuality' or oxvarname = 'sDefaultImageQualityPhone') and
          {$decodeField} = " . $db->quote($quality);

        $shopIdsArray = $db->getAll($q);

        // building query:
        // shop id
        $shopIds = implode(', ', array_map(function ($shopId) use ($db) {
            // probably here we can resolve and check shop id to shorten check?
            return $db->quote($shopId['oxshopid']);
        }, $shopIdsArray));


        // any shop matching quality
        if ($shopIds) {
          $checkSize1 = "$width*$height";
          $checkSize2 = intval($width/2)."*".intval($height/2); // for retina images = "$width*$height";

          // selecting config variables to check
          $q = "select oxvartype, {$decodeField} as oxvarvalue from oxconfig
            where oxvarname in ( {$names} ) and oxshopid in ( {$shopIds} ) order by oxshopid";
          $values = $db->getAll($q);
          foreach ($values as $value) {
            $confValues = (array) $config->decodeValue($value["oxvartype"], $value["oxvarvalue"]);
            foreach ($confValues as $confValue) {
              if (strcmp($checkSize1, $confValue) == 0) {
                $valid = true;
                break;
              }
              if (strcmp($checkSize2, $confValue) == 0) {
                $valid = true;
                break;
              }
            }
          }
        }
      }
    }
    return $valid;
  }
}
require_once getShopBasePath()."getimg.php";
