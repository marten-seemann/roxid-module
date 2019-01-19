<?php
class roxid_admin_navigation extends roxid_admin_navigation_parent {
  protected $sRoxidUpdateCheckUrl = 'https://updates.oxid-responsive.com/getlatestversion/';

  /**
  * add message to the message array, if ROXID update is available
  *
  * @return string
  */
  protected function _doStartUpChecks() {
    $aMessage = parent::_doStartUpChecks();
    $roxid_check = $this->_checkRoxidUpdates();
    if($roxid_check !== false) {
      $aMessage['message'] = ((!empty($aMessage['message'])) ? "<br>" : '').$roxid_check;
    }
    return $aMessage;
  }

  /**
  * check with the ROXID update server if a ROXID update is available
  *
  * @return if update is available: the message to display, else: false
  */
  protected function _checkRoxidUpdates() {
    $oConfig = $this->getConfig();

    $sBase = $oConfig->getParentTemplateBase();
    if($sBase === false) { // if the currently active theme is NOT a child theme of another theme
      $sBase = $oConfig->getTemplateBase();
    }
    // load the theme.php
    require($oConfig->getConfigParam('sShopDir').$sBase."theme.php");

    $name = $aTheme['id'];
    $version = $aTheme['version'];
    $sUrl = $this->sRoxidUpdateCheckUrl.urlencode($name);
    $sVersion = trim(oxRegistry::get("oxUtilsFile")->readRemoteFileAsString($sUrl));
    if(substr($sVersion, 0, 1) == "v") $sVersion = substr($sVersion, 1); // remove a leading v in front of version, if exists
    if ($sVersion) {
      // current version is older ..
      if (version_compare($version, $sVersion) == '-1') {
        return sprintf(oxRegistry::getLang()->translateString('ROXID_NEWVERSIONAVAILABLE'), $sVersion);
      }
    }
    return false;
  }
}
