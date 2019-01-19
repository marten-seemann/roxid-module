<?php
// add a "@2x" in front of the extension if we are dealing with a retina device
function retinafy($url) {
  if(strlen($url) == 0) return $url;
  if(!oxRegistry::getConfig()->getConfigParam("blRetinaImages")) return $url;
  if(!oxRegistry::getConfig()->isRetinaDevice()) return $url;

  $path_parts = pathinfo($url);
  if($path_parts['basename'] == "nopic.jpg") return $url;
  $url_retina = $path_parts['dirname']."/".$path_parts['filename']."@2x".".".$path_parts['extension'];
  return $url_retina;
}
