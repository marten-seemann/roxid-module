<?php
namespace SeemannIT\Roxid\Application\Model;

require_once(dirname(__FILE__)."/../../inc/retinafy.php");

class Manufacturer extends Manufacturer_parent {
  public function getIconUrl() {
    $url = parent::getIconUrl();
    return retinafy($url);
  }
}
