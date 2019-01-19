<?php
require_once(dirname(__FILE__)."/../inc/retinafy.php");

class roxid_extend_oxmanufacturer extends roxid_extend_oxmanufacturer_parent {
  public function getIconUrl() {
    $url = parent::getIconUrl();
    return retinafy($url);
  }
}
