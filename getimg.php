<?php
// Checks if instance name getter does not exist
if ( !function_exists( "getGeneratorInstanceName" ) ) {
  /**
  * Returns image generator instance name
  *
  * @return string
  */
  function getGeneratorInstanceName() {
    return SeemannIT\Roxid\Core\DynamicImageGenerator::class;
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

SeemannIT\Roxid\Core\DynamicImageGenerator::getInstance()->outputImage();

// $file = dirname(__FILE__)."/../../responsive_slider/utils/getimg.php";
// if(file_exists($file)) {
//   require(dirname(__FILE__)."/../../responsive_slider/utils/getimg.php");
// }
// else {
//   class sliderdynimggenerator extends OxidEsales\EshopCommunity\Core\DynamicImageGenerator { }
// }
