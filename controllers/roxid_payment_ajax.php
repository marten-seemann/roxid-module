<?php
class roxid_payment_ajax extends roxid_payment_ajax_parent {
  public function render() {
    if(oxRegistry::getConfig()->getRequestParameter('renderPartial')) {
      $this->addTplParam( 'renderPartial', true );
    }
    $parentTpl = parent::render();
    return $parentTpl;
  }
}
