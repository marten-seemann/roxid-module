<?php
class roxid_extend_oxconfig extends roxid_extend_oxconfig_parent {

  protected $_sFaviconDir = 'build/favicons';
  protected $blForceRetinaDevice = null; // should take a bool
  protected $sForcedDeviceType = null; // shoud take a string
  /**
  * breakpoints for the resolution
  * everything up to this value is considered a smartphone
  * everything larger is considered a desktop computer
  */
  protected $phone_breakpoint = 767;
  protected $device_type;
  protected $is_retina_device = false; // bool

  protected $image_types = array(
    "sDefaultImageQuality",
    "sThumbnailsize",
    "sCatThumbnailsize",
    "sCatIconsize"
  );

  public function __construct() {
    $this->detectDevice();
    parent::__construct();
  }

  /**
   * Finds and returns base template folder url of the parent theme
   * if the theme is not a child theme of any other theme, return false
   *
   * @param bool $blAdmin Whether to force admin
   *
   * @return mixed
   */
  public function getParentTemplateBase($blAdmin = false) {
    if(!$this->getConfigParam('sCustomTheme')) {
      return false;
    }

    // Base template dir is the parent dir of template dir
    return str_replace($this->getConfigParam('sCustomTheme'), $this->getConfigParam('sTheme'), $this->getTemplateBase($blAdmin));
  }

  /**
  * set the class variable to force a specific value for the isRetinaDevice() function
  */
  public function setForceRetinaDevice($val) {
    $this->blForceRetinaDevice = (bool) $val;
  }

  /**
  * unset the class variable to force a specific value for the isRetinaDevice() function
  */
  public function unsetForceRetinaDevice() {
    unset($this->blForceRetinaDevice);
  }

  /**
  * set the class variable to force a specific value for the getDeviceType() function
  */
  public function setForceDeviceType($val) {
    $this->sForcedDeviceType = $val;
  }

  /**
  * unset the class variable to force a specific value for the getDeviceType() function
  */
  public function unsetForceDeviceType() {
    unset($this->sForcedDeviceType);
  }

  /**
   * Finds and returns image folder url
   *
   * @param bool   $blSSL       Whether to force ssl
   * @param string $sFile       Favicon file name
   *
   * @return string
   */
  public function getFaviconUrl($blSSL = null, $sFile = null) {
    return $this->getUrl($sFile, $this->_sFaviconDir, $blAdmin = false, $blSSL);
  }

  /**
  * read the "resolution" cookie and determine which device we are dealing with using the $resolution_breakpoints
  * also determine if we are dealing with a retina device
  *
  * @return one of the following values: phone, desktop or unknown
  */
  public function detectDevice() {
    if(isset($_COOKIE['resolution'])) {
      $vals = explode(",", $_COOKIE['resolution']);
      // detect device type
      $resolution = intval($vals[0]);
      if($resolution < $this->phone_breakpoint) $this->device_type = "phone";
      else $this->device_type = "desktop";
      // is this a retina device?
      if(count($vals) > 1) { // cookie contains information about device_ratio
        $device_ratio = floatval($vals[1]);
        if($device_ratio > 1) $this->is_retina_device = true;
        else $this->is_retina_device = false;
      }

    }
    else {
      $this->is_retina_device = true; // treat every device as a retina device (we can do so because it does not cost too much bandwidth)
      $this->device_type = "unknown";
    }
    return $this->device_type;
  }

  /**
  * @return the device returned by the detectDevice() function
  */
  public function getDeviceType() {
    if(isset($this->sForcedDeviceType)) return $this->sForcedDeviceType;
    return $this->device_type;
  }

  /**
  * @return bool  does the device have a retina screen? Or ROXID_FORCE_RETINA_DEVICE, if set
  */
  public function isRetinaDevice() {
    if(isset($this->blForceRetinaDevice)) return $this->blForceRetinaDevice;
    return $this->is_retina_device;
  }

  /**
  * get a configuration parameter as the OXID function would do
  * only difference: if an image dimension is requested, return the image dimension for the device detected by detectDevice()
  *
  * @param string   $sName config parameter name
  * @return string  the configuration parameter
  */
  public function getConfigParam($sName) {
    $sNameMod = $sName;
    $device_type = $this->getDeviceType();

    if($device_type == "phone") {
      if(in_array($sName, $this->image_types)) {
      // var_dump($sName);
        if($device_type == "phone") $sNameMod = $sName."Phone";
      }
    }

    return parent::getConfigParam($sNameMod);
  }
}
