<?php
require_once(dirname(__FILE__)."/../inc/retinafy.php");

class roxid_extend_oxarticle extends roxid_extend_oxarticle_parent {
  /**
  * get image dimensions of the master pictures
  * needed for the PhotoSwipe library
  *
  * @param int $iIndex the index of the picture
  * @return array width and height of the picture
  */
  public function getMasterZoomPictureDimensions($iIndex) {
    $myConfig = $this->getConfig();
    $sPicName = basename($this->{"oxarticles__oxpic" . $iIndex}->value);
    if($sPicName == "nopic.jpg") return false;
    $sPicPath = $myConfig->getPictureDir(false)."master/product/" . $iIndex . "/" . $sPicName;
    $aImgSize = getimagesize($sPicPath);
    $ret = array(
      "width" => $aImgSize[0],
      "height" => $aImgSize[1]
      );
    return $ret;
  }

  public function getThumbnailUrl( $bSsl = null ) {
    $url = parent::getThumbnailUrl( $bSsl );
    return retinafy($url);
  }

  public function getPictureUrl( $iIndex = 1 ) {
    $url = parent::getPictureUrl( $iIndex );
    return retinafy($url);
  }

  public function getIconUrl( $iIndex = 0 ) {
    $url = parent::getIconUrl( $iIndex );
    return retinafy($url);
  }
}
