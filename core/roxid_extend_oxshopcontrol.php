<?php
class roxid_extend_oxshopcontrol extends roxid_extend_oxshopcontrol_parent {
  protected function _render($oViewObject) {
    $oRet = parent::_render($oViewObject);

    // will be called by the ajaxbasket to make sure that error messages are only shown once
    if (oxRegistry::getConfig()->getRequestParameter('clearErrors')) {
      $this->_aErrors = array();
      $this->_aAllErrors = array();
      oxRegistry::getSession()->setVariable('ErrorController', null);
      oxRegistry::getSession()->setVariable('Errors', $this->_aAllErrors);
    }

    return $oRet;
  }
}
