<?php
namespace SeemannIT\Roxid\Application\Controller;

class PaymentController extends PaymentController_parent {
  public function render() {
    if(\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('renderPartial')) {
      $this->addTplParam( 'renderPartial', true );
    }
    $parentTpl = parent::render();
    return $parentTpl;
  }
}
