<?php
namespace SeemannIT\Roxid\Application\Model;

class Categorylist extends Categorylist_parent {
  public function getLoadFull() {
    return true; // we must load the whole category tree to show 2nd level subcategories in the mobile navigation
    // $oConf = \OxidEsales\Eshop\Core\Registry::get("oxConfig");
    // if($oConf->getConfigParam('blShowNavbarSubMenus')) return true; // we must load the whole category tree if we want to show 2nd level subcategories in the navigation
    // else return $this->_blForceFull;
  }
}
