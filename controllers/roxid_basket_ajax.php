<?php
class roxid_basket_ajax extends roxid_basket_ajax_parent {
  public function render() {
    if(oxRegistry::getConfig()->getRequestParameter('renderPartial')) {
      $this->addTplParam( 'editable', true );
      $this->addTplParam( 'renderPartial', true );
    }
    return parent::render();
  }
}
