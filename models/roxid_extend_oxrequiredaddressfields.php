<?php
class roxid_extend_oxrequiredaddressfields extends roxid_extend_oxrequiredaddressfields_parent {
  /**
  * remove input fields, that were disabled via an backend option, from the array of required inputs
  *
  * @return array
  */
  public function getRequiredFields() {
    $oConfig = oxRegistry::getConfig();

    $aRet = parent::getRequiredFields();

    $aDisabledFields = array();
    if(!$oConfig->getConfigParam('blShowFax')) $aDisabledFields[] = 'oxfax';
    if(!$oConfig->getConfigParam('blShowFon')) $aDisabledFields[] = 'oxfon';
    if(!$oConfig->getConfigParam('blShowMobFon')) $aDisabledFields[] = 'oxmobfon';
    if(!$oConfig->getConfigParam('blShowPrivFon')) $aDisabledFields[] = 'oxprivfon';

    foreach($aRet as $key => $value) {
      foreach($aDisabledFields as $sField) {
        if($value == "oxuser__".$sField OR $value == "oxaddress__".$sField) unset($aRet[$key]);
      }
    }
    return $aRet;
  }


}
