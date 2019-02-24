<?php
namespace SeemannIT\Roxid\Application\Model;

class BasketItem extends BasketItem_parent {
  /**
   * Returns article thumbnail picture url
   *
   * @return string
   */
  public function getThumbnailUrl() {
    return $this->getArticle()->getThumbnailUrl($this->_bSsl);
  }
}
