<?php
function getCurrentDir() {
  // use $_SERVER["SCRIPT_FILENAME"] instead of __DIR__, since __DIR__ resolves symlinks
  return dirname($_SERVER["SCRIPT_FILENAME"]);
}

// Checks if instance name getter does not exist
if ( !function_exists( "getGeneratorInstanceName" ) ) {
  /**
  * Returns image generator instance name
  *
  * @return string
  */
  function getGeneratorInstanceName() {
    require_once getCurrentDir() . "/../../../bootstrap.php";

    if(\OxidEsales\Eshop\Core\Registry::get("oxViewConfig")->isModuleActive("responsiveslider")) {
      return \SeemannIT\ResponsiveSliderModule\Core\DynamicImageGenerator::class;
    } 
    return SeemannIT\Roxid\Core\DynamicImageGenerator::class; 
  }
}

require_once getCurrentDir() . "/../../../getimg.php";
