<?php
class roxid_extend_oxcategorylist extends roxid_extend_oxcategorylist_parent {
  public function getLoadFull() {
    return true; // we must load the whole category tree to show 2nd level subcategories in the mobile navigation
    // $oConf = oxRegistry::get("oxConfig");
    // if($oConf->getConfigParam('blShowNavbarSubMenus')) return true; // we must load the whole category tree if we want to show 2nd level subcategories in the navigation
    // else return $this->_blForceFull;
  }
}
