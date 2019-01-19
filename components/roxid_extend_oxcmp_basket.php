<?php
class roxid_extend_oxcmp_basket extends roxid_extend_oxcmp_basket_parent {
  protected function _getRedirectUrl() {
    $oConfig = $this->getConfig();
    if($oConfig->getRequestParameter("useAjax")) return "ajaxbasket?clearErrors=true";
    else return parent::_getRedirectUrl();
  }
}
