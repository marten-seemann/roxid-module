<?php
session_start();
require dirname(__FILE__)."/inc/includes.php";

$dir = "../../../out/roxid_mod/";
$dir_hr = "out/roxid_mod/";
$authenticated_user = checkAuthentication();

// Generate CSRF token to use in form hidden field
$csrf_token = NoCSRF::generate( 'csrf_token' );
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ROXID LESS Compiler</title>
  <link rel="stylesheet" href="assets/build/css/styles.css">

  <script type="text/javascript">
      less = {
          env: "production", // or "production"
          async: true,       // load imports async
          fileAsync: true,   // load imports async when in a page under
                              // a file protocol
          poll: 1000,         // when in watch mode, time in ms between polls
          functions: {},      // user functions, keyed by name
          dumpLineNumbers: false, // or "mediaQuery" or "all"
          relativeUrls: false,// whether to adjust url's to be relative
                              // if false, url's are already relative to the
                              // entry less file
          rootpath: ":/a.com/"// a path to add on to the start of every url
                              //resource
      };
      <?php
      if($authenticated_user) {
        // echo "srcfiles = ".json_encode(array_keys(array_reverse($paths))).";";
        echo "dir = ".json_encode($dir).";";
        echo "srcfiles = ".json_encode(array_keys($paths)).";";
      }
      ?>
  </script>

</head>
<body>

  <h1>ROXID LESS Compiler</h1>
  <p>Please wait while compiling and compressing the LESS files. This may take a while...</p>
  <?php
    $error = false;
    foreach($paths as $src => $dest) {
      $path = $dir.$dest;
      $path_dir = dirname($path);
      if(!is_dir($path_dir)) {
        if(!@mkdir($path_dir, 0777, true)) { // recursively create the directory
          echo "<p class='error'><strong>Error: </strong>Unable to create output directory <em>".$dir_hr.dirname($dest)."</em>.</p>";
          $error = true;
          break;
        }
      }
      if(file_exists($path)) { // check if the already existing file can we (over)written
        if(!is_writable($path)) {
          $error = true;
          echo "<p class='error'><strong>Error: </strong>Please make sure that the file <em>".$dir_hr.$dest."</em> is writable.</p>";
          break;
        }
      }
      else { // else, check if we are allowed to write into this directory
        if(!is_writable($path_dir)) {
          $error = true;
          echo "<p class='error'><strong>Error: </strong>Please make sure that the file <em>".$dir_hr.dirname($dest)."</em> is writable.</p>";
          break;
        }
      }
    }
  ?>
  <?php
    if(!$error) {
      if($authenticated_user === false) {
        echo "
          <p class='error'><strong>Error:</strong> For security reasons, it is only possible to use the ROXID Asset Compiler if the directory is password protected.</p>
          <p>Please enable a password protection with <em>.htaccess</em> and <em>.htpasswd</em> for the following directory: <em>";
        $path = realpath(dirname(__FILE__));
        echo substr($path, strpos($path, $dir_hr))."/";
        echo "</em></div>";
      }
      else {
        echo "<h2>Compiling LESS code</h2>";
        echo "<ul>";
        foreach($paths as $src => $dest) {
          echo "<li>Compiling <strong>$dir_hr$src</strong> to <strong>$dir_hr$dest</strong>...<br>";
          if(!checkWritable($dir.$dest)) {
            echo "
              <div class='error'><strong>Error:</strong> File <em>$dest</em> is not writable.</div>";
          }
          else {
            echo "
              <div class='status' data-file='$src'>
                <div class='compile-error alert alert-danger'></div>
                <div class='compile-status'>
                  <div class='uncompressed' style='display: none'><strong>$dir_hr$dest</strong>: <span class='status'></span></div>
                  <div class='compressed' style='display: none'><strong>".str_replace(".css", ".min.css", $dir_hr.$dest)."</strong>: <span class='status'></span></div>
                  <div class='wait'>Please wait...</div>
                </div>
              </div>";
            }
            echo "</li>";
        }
        echo "</ul>";
        flush();
      }
    }
    ?>

  <div id="error-messages"></div>


  <p id="finished" style="display: none">All tasks finished.</p>

  <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $csrf_token; ?>">

  <?php
    if(!$error) {
  ?>
  <script src="assets/build/js/jquery-1.11.2.min.js" type="text/javascript"></script>
  <script src="assets/build/js/less.min.js" type="text/javascript"></script>
  <script src="assets/build/js/autoprefixer.js" type="text/javascript"></script>
  <script src="assets/build/js/compile.js" type="text/javascript"></script>
  <?php } ?>
</body>
</html>
