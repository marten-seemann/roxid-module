<?php
class roxid_extend_oxviewconfig extends roxid_extend_oxviewconfig_parent {
  protected $icon_config;

  /**
  * read the icon config file and save the configuration into a class variable
  *
  */
  public function __construct() {
    $this->_loadIconConfig();
    parent::__construct();
  }

  /*
  * load FontAwesome icon configuration
  * load parent theme first, then do the overwrites with the config from the child theme, if applicable
  */
  protected function _loadIconConfig() {
    $oConfig = $this->getConfig();
    $sParentBase = $oConfig->getParentTemplateBase();
    $icon_config = array();
    if($sParentBase !== false) { // if this is a child theme, load the icon config of the parent theme first
      require($oConfig->getConfigParam('sShopDir').$sParentBase."icon_config.php");
      $icon_config = $icons;
    }
    // load icon config of the theme
    $icons = array();
    $sFile = $oConfig->getConfigParam('sShopDir').$oConfig->getTemplateBase()."icon_config.php";
    if(file_exists($sFile)) {
      require($sFile);
    }
    $this->icon_config = array_merge($icon_config, $icons);
  }

  /**
   * Returns favicon url
   *
   * @param string $sFile Favicon file name
   * @param bool   $bSsl  Whether to force SSL
   *
   * @return string
   */
  public function getFaviconUrl($sFile = null, $bSsl = null) {
    return $this->getConfig()->getFaviconUrl($bSsl, $sFile);
  }

  /**
   * Template variable getter. Returns if review module is on
   *
   * @return bool
   */
  public function isRatingActive()
  {
      return $this->getConfig()->getConfigParam('bl_perfLoadReviews');
  }

  /**
  * get the base dir of the shop, but without the port number
  *
  * @return string
  */
  public function getBaseDirWithoutPort() {
    $url = $this->getBaseDir();
    $parsed_url = parse_url($url);
    $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    // $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
    $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    // $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    // $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    // $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    return $scheme.$user.$pass.$host;
  }

  /**
  * get the device as detected in the roxidOxConfig class
  *
  * @return string
  */
  public function detectDevice() {
    return $this->getConfig()->getDeviceType();
  }

  public function setForceRetinaDevice($val) {
    $this->getConfig()->setForceRetinaDevice($val);
  }

  public function unsetForceRetinaDevice() {
    $this->getConfig()->unsetForceRetinaDevice();
  }

  public function setForceDeviceType($val) {
    $this->getConfig()->setForceDeviceType($val);
  }

  public function unsetForceDeviceType() {
    $this->getConfig()->unsetForceDeviceType();
  }

  /**
  * get image dimensions for all device types
  *
  * @param string   $sName config parameter name
  *
  * @return array   an associative array containing the configured image dimensions
  */
  public function getImageDimensionsForDevices($sName) {
    return array(
      "phone" => $this->getConfig()->getConfigParam($sName."Phone", false),
      "desktop" => $this->getConfig()->getConfigParam($sName, false)
      );
  }

  /**
  * get the FontAwesome icon code
  *
  * @param string   $name the name of the icon as specified in the icon_config file
  *
  * @return string  the HTML code for the corresponding FontAwesome icon
  */
  public function getRoxidIcon($name, $addition = '') {
    if(array_key_exists($name, $this->icon_config)) {
      $class = $this->icon_config[$name];
      if(!empty($addition)) $class .= " ".$addition;
      return "<i class=\"fa $class\"></i>";
    }
    else { /// only throw an error if the shop is not running in productive mode
      if(!$this->getConfig()->getActiveShop()->oxshops__oxproductive->value) throw oxNew( "oxException", "Requested icon $name does not exist." );
      else die;
    }
  }

  /**
  * get version infos about ROXID
  *
  * @return array  containing title and version number
  */
  public function getRoxidInfos() {
    require($this->getConfig()->getTemplateBase()."theme.php");
    return array(
      "title" => $aTheme["title"],
      "version" => $aTheme["version"]
      );
  }

  /**
  * get all lang strings for translating javascript
  *
  * all strings from js_lang.php and cust_js_lang.php are returned
  * if a child theme is activated, the corresponding lang files are included, too
  *
  * @return array[string] the localization with all JavaScript lang strings
  */
  public function getJsLangStrings() {
    $oLang = oxRegistry::getLang();

    $langkeys= $oLang->getJsLangKeys();
    $dict = array();
    foreach($langkeys as $langkey) {
      try {
        $dict[$langkey] = $oLang->translateString($langkey);
      }
      catch ( oxLanguageException $oEx ) {
      }
    }
    return $dict;
  }
}
