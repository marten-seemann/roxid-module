<?php
class roxid_extend_oxutilspic extends roxid_extend_oxutilspic_parent {
  // when deleting a picture, make sure to delete the @2x version, too
  public function safePictureDelete($sPicName, $sAbsDynImageDir, $sTable, $sField) {
    $pinfo = pathinfo($sPicName);
    $sPicNameRetina = $pinfo['filename']."@2x.".$pinfo['extension'];
    $ret1 = parent::safePictureDelete($sPicName, $sAbsDynImageDir, $sTable, $sField);
    $ret2 = parent::safePictureDelete($sPicNameRetina, $sAbsDynImageDir, $sTable, $sField);
    return ($ret1 && $ret2);
  }
}
