<?php
namespace SeemannIT\Roxid\Core;

class InputValidator extends InputValidator_parent {
  public function checkPassword($oUser, $sNewPass, $sConfPass, $blCheckLength = false) {
    $oConfig = $this->getConfig();
    if(!$oConfig->getConfigParam('blShowPasswordConfirm')) { // password confirm input not shown => trick checkPassword() into thinking that the confirmation input was filled with the same password
      $sConfPass = $sNewPass;
    }
    return parent::checkPassword($oUser, $sNewPass, $sConfPass, $blCheckLength);
  }
}
