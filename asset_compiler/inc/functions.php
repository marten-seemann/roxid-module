<?php
function checkWritable($path) {
  $exists = file_exists($path);
  if($exists) return is_writable(dirname($path));
  else return @touch($path);
}

function checkAuthentication() {
  global $config;
  if(isset($config['disable_auth_check']) AND $config['disable_auth_check']) return true;
  return isAuthenticatedUser();
}

function isAuthenticatedUser() {
  if(isset($_SERVER['PHP_AUTH_USER'])) $user = $_SERVER['PHP_AUTH_USER'];
  else if(isset($_SERVER['REMOTE_USER'])) $user = $_SERVER['REMOTE_USER'];
  else if(isset($_SERVER['REDIRECT_REMOTE_USER'])) $user = $_SERVER['REDIRECT_REMOTE_USER'];
  else return false;

  if(strlen($user) > 0) return true;
  else return false;
}
