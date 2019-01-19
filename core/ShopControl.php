<?php
namespace SeemannIT\Roxid\Core;

class ShopControl extends ShopControl_parent {
  protected function _render($oViewObject) {
    $oRet = parent::_render($oViewObject);

    // will be called by the ajaxbasket to make sure that error messages are only shown once
    if (\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('clearErrors')) {
      $this->_aErrors = array();
      $this->_aAllErrors = array();
      \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('ErrorController', null);
      \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('Errors', $this->_aAllErrors);
    }

    return $oRet;
  }
}
