<?php
session_start();

// do not show PHP deprecated warnings
error_reporting(error_reporting() & (-1 ^ E_DEPRECATED));

require dirname(__FILE__)."/inc/includes.php";
require dirname(__FILE__)."/libs/cssmin.php";


// Run CSRF check, on POST data, in exception mode, for 5 minutes, in one-time mode.
try {
  NoCSRF::check( 'csrf_token', $_POST, true, 5*60, true );
}
catch( Exception $e ) {
  echo $e->getMessage();
  die;
}


// only accept input if there is a htaccess password protection for the directory and the user is logged in
// prevents attackers from overwriting the css files of the shop
if(!checkAuthentication()) {
  die("Not authorized");
}


$dir = "../../../out/roxid_mod/";

$path = $_POST['path'];
if(isset($_POST['content'])) $content = $_POST['content'];
$mode = $_POST['mode'];


// do some matching to improve security
$hack = true;
$dest = "";

$key = $path;
if(array_key_exists($key, $paths)) {
  $hack = false;
  $dest = $paths[$key];
}
if($hack) die("Shutting down for security reasons.");

if($mode == "save") {
  $result = array(
    "uncompressed" => false,
    "compressed_backup" => false
    );

  $res = file_put_contents($dir.$dest, $content, LOCK_EX);
  if($res !== false) {
    $result["uncompressed"] = true;
    $dest_backup = str_replace(".css", ".min.css", $dest);
    $res = copy($dir.$dest, $dir.$dest_backup);
    if($res !== false) $result["compressed_backup"] = true;
  }
}
else if($mode == "compress") {
  $result = array(
    "compressed" => false
    );

  $compressor = new CSSmin();
  $compressor->set_memory_limit('256M');
  $compressor->set_max_execution_time(120);
  $compressor->set_pcre_backtrack_limit(3000000);
  $compressor->set_pcre_recursion_limit(150000);

  $outputpath = str_replace(".css", ".min.css", $dest);
  $res = file_put_contents($dir.$outputpath, $compressor->run(file_get_contents($dir.$dest)));
  if($res !== false) $result["compressed"] = true;
}

echo json_encode($result);
