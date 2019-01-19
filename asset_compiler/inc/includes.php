<?php
require dirname(__FILE__)."/../config.php";
require dirname(__FILE__)."/../libs/nocsrf.php";
require dirname(__FILE__)."/functions.php";
require dirname(__FILE__)."/paths.php";

// magic quotes are not welcome here
if (get_magic_quotes_gpc()) {
  function stripslashes_gpc(&$value) {
    $value = stripslashes($value);
  }
  array_walk_recursive($_GET, 'stripslashes_gpc');
  array_walk_recursive($_POST, 'stripslashes_gpc');
  array_walk_recursive($_COOKIE, 'stripslashes_gpc');
  array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}
