<?php
namespace SeemannIT\Roxid\Application\Component;

class BasketComponent extends BasketComponent_parent {
  protected function _getRedirectUrl() {
    $oConfig = $this->getConfig();
    if($oConfig->getRequestParameter("useAjax")) return "ajaxbasket?clearErrors=true";
    else return parent::_getRedirectUrl();
  }
}
