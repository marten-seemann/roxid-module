<?php
class roxid_extend_oxlang extends roxid_extend_oxlang_parent {
  /**
  * get all paths to language files for a specified language and the selected theme
  *
  * it is not checked if these files really exist
  *
  * @param $iLang the language
  * @return array[string] array containing all paths to the language files
  */
  protected function _getJsLangPaths($iLang) {
    $oConfig = $this->getConfig();
    $sAppDir        = $oConfig->getAppDir();
    $sLang = oxRegistry::getLang()->getLanguageAbbr($iLang);
    $sTheme         = $oConfig->getConfigParam( "sTheme" );
    $sCustomTheme   = $oConfig->getConfigParam( "sCustomTheme" );

    $basePath = $sAppDir . 'views/';

    $files = array(
      $basePath. $sTheme .'/' . $sLang . '/js_lang.php',
      $basePath. $sTheme .'/' . $sLang . '/cust_js_lang.php'
      );
    if(!empty($sCustomTheme)) {
      $files[] = $basePath. $sCustomTheme .'/' . $sLang . '/js_lang.php';
      $files[] = $basePath. $sCustomTheme .'/' . $sLang . '/cust_js_lang.php';
    }

    return $files;
  }


  /**
  * get all language string keys that are defined in language files for JavaScript lang strings
  *
  * @param $iLang the language
  * @return array[string] array of all the language string keys (NOT the translations itself!)
  */
  public function getJsLangKeys($iLang = 0) {
    $sLangFiles = $this->_getJsLangPaths($iLang);
    $keys = array();
    foreach($sLangFiles as $sLangFile) {
      if ( file_exists( $sLangFile ) && is_readable( $sLangFile ) ) {
        include $sLangFile;
        unset($aLang['charset']);
        $keys = array_merge($keys, array_keys($aLang));
      }
    }
    return $keys;
  }
}
