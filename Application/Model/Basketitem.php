<?php
namespace SeemannIT\Roxid\Application\Model;

class Basketitem extends Basketitem_parent {
  /**
   * Returns article thumbnail picture url
   *
   * @return string
   */
  public function getThumbnailUrl() {
    return $this->getArticle()->getThumbnailUrl($this->_bSsl);
  }
}
