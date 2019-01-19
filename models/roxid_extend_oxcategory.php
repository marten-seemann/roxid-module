<?php
require_once(dirname(__FILE__)."/../inc/retinafy.php");

class roxid_extend_oxcategory extends roxid_extend_oxcategory_parent {
  public function getThumbUrl() {
    $url = parent::getThumbUrl();
    return retinafy($url);
  }

  public function getIconUrl() {
    $url = parent::getIconUrl();
    return retinafy($url);
  }
}
