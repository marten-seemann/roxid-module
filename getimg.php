<?php
// Checks if instance name getter does not exist
if ( !function_exists( "getGeneratorInstanceName" ) ) {
  /**
  * Returns image generator instance name
  *
  * @return string
  */
  function getGeneratorInstanceName() {
    return SeemannIT\Roxid\Core\DynamicImageGenerator::class;
  }
}

// use $_SERVER["SCRIPT_FILENAME"] instead of __DIR__, since __DIR__ resolves symlinks
$dirname = dirname($_SERVER["SCRIPT_FILENAME"]);
require_once $dirname . "/../../../bootstrap.php";

if(\OxidEsales\Eshop\Core\Registry::get("oxViewConfig")->isModuleActive("responsiveslider")) {
  \SeemannIT\ResponsiveSliderModule\Core\DynamicImageGenerator::getInstance()->outputImage();
} else {
  SeemannIT\Roxid\Core\DynamicImageGenerator::getInstance()->outputImage();
}
