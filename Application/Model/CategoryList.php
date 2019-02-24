<?php
namespace SeemannIT\Roxid\Application\Model;

class CategoryList extends CategoryList_parent {
  public function getLoadFull() {
    $oConf = \OxidEsales\Eshop\Core\Registry::get("oxConfig");
    if($oConf->getConfigParam('blShowNavbarSubMenus')) {
      // we must load the whole category tree if we want to show 2nd level subcategories in the navigation
      return true;
    }
    return parent::getLoadFull(); 
  }
}
