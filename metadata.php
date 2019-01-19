<?php
/**
 *    This file is part of the ROXID template.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'           => 'roxid',
    'title'        => '<span style=\'letter-spacing:0.09em\'><strong style=\'color: #84AA4C;\'>R</strong>OXID</span>',
    'description'  => array(
        'en' => '',
        'de' => ''
        ),
    // 'thumbnail'    => 'picture.png',
    'version'      => '3.4.5',
    'author'       => 'Marten Seemann',
    'extend'       => array(
        'oxconfig' => 'roxid/core/roxid_extend_oxconfig',
        'oxlang' => 'roxid/core/roxid_extend_oxlang',
        'oxinputvalidator' => 'roxid/core/roxid_extend_oxinputvalidator',
        'oxviewconfig' => 'roxid/core/roxid_extend_oxviewconfig',
        'oxshopcontrol' => 'roxid/core/roxid_extend_oxshopcontrol',
        'oxutilspic' => 'roxid/core/roxid_extend_oxutilspic',
        'oxarticle' => 'roxid/models/roxid_extend_oxarticle',
        'oxbasketitem' => 'roxid/models/roxid_extend_oxbasketitem',
        'oxcategory' => 'roxid/models/roxid_extend_oxcategory',
        'oxcategorylist' => 'roxid/models/roxid_extend_oxcategorylist',
        'oxmanufacturer' => 'roxid/models/roxid_extend_oxmanufacturer',
        'oxrequiredaddressfields' => 'roxid/models/roxid_extend_oxrequiredaddressfields',
        'basket' => 'roxid/controllers/roxid_basket_ajax',
        'navigation' => 'roxid/controllers/roxid_admin_navigation',
        'payment' => 'roxid/controllers/roxid_payment_ajax',
        'oxcmp_basket'  => 'roxid/components/roxid_extend_oxcmp_basket',
    ),
    'files'        => array(
        'ajaxbasket' => 'roxid/controllers/ajaxbasket.php'
    ),
    'templates'    => array(
        'messages.tpl' => 'roxid/views/messages.tpl'
    ),
    'url' => 'http://www.oxid-responsive.com'
);
