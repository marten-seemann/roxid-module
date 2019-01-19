<?php
namespace SeemannIT\Roxid\Application\Model;

class Basketitem extends Basketitem_parent {
  protected function _setArticle($sProductId) {
    parent::_setArticle($sProductId);
    $oArticle = $this->getArticle(true, $sProductId);
    $this->_sThumbnailUrl = $oArticle->getThumbnailUrl();
  }

  /**
   * Returns article thumbnail picture url
   *
   * @return string
   */
  public function getThumbnailUrl()
  {
      // icon url must be (re)loaded in case icon is not set or shop was switched between ssl/nonssl
      if ($this->_sThumbnailUrl === null || $this->_blSsl != $this->getConfig()->isSsl()) {
          $this->_sThumbnailUrl = $this->getArticle()->getThumbnailUrl();
      }

      return $this->_sThumbnailUrl;
  }
}
