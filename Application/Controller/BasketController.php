<?php
namespace SeemannIT\Roxid\Application\Controller;

class BasketController extends BasketController_parent {
  public function render() {
    if(\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('renderPartial')) {
      $this->addTplParam('editable', true);
      $this->addTplParam('renderPartial', true);
    }
    return parent::render();
  }
}
