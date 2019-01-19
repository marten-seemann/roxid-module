<?php
namespace SeemannIT\Roxid\Application\Model;

require_once(dirname(__FILE__)."/../../inc/retinafy.php");

class Category extends Category_parent {
  public function getThumbUrl() {
    $url = parent::getThumbUrl();
    return retinafy($url);
  }

  public function getIconUrl() {
    $url = parent::getIconUrl();
    return retinafy($url);
  }
}
