<?php
/**
 *    This file is part of the ROXID template.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'           => 'roxid',
    'title'        => '<span style=\'letter-spacing:0.09em\'><strong style=\'color: #84AA4C;\'>R</strong>OXID</span>',
    'description'  => [
        'en' => '',
        'de' => ''
    ],
    // 'thumbnail'    => 'picture.png',
    'version'      => '3.4.5',
    'author'       => 'Marten Seemann',
    'extend'       => [
        \OxidEsales\Eshop\Application\Component\BasketComponent::class => \SeemannIT\Roxid\Application\Component\BasketComponent::class,
        \OxidEsales\Eshop\Application\Controller\Admin\NavigationController::class => \SeemannIT\Roxid\Application\Controller\Admin\NavigationController::class,
        \OxidEsales\Eshop\Application\Controller\Admin\NavigationController::class => \SeemannIT\Roxid\Application\Controller\Admin\NavigationController::class,
        \OxidEsales\Eshop\Application\Controller\BasketController::class => \SeemannIT\Roxid\Application\Controller\BasketController::class,
        \OxidEsales\Eshop\Application\Controller\PaymentController::class => \SeemannIT\Roxid\Application\Controller\PaymentController::class,
        \OxidEsales\Eshop\Core\Config::class => \SeemannIT\Roxid\Core\Config::class,
        \OxidEsales\Eshop\Core\DynamicImageGenerator::class => \SeemannIT\Roxid\Core\DynamicImageGenerator::class,
        \OxidEsales\Eshop\Core\InputValidator::class => \SeemannIT\Roxid\Core\InputValidator::class,
        \OxidEsales\Eshop\Core\Language::class => \SeemannIT\Roxid\Core\Language::class,
        \OxidEsales\Eshop\Core\ShopControl::class => \SeemannIT\Roxid\Core\ShopControl::class,
        \OxidEsales\Eshop\Core\UtilsPic::class => \SeemannIT\Roxid\Core\UtilsPic::class,
        \OxidEsales\Eshop\Core\ViewConfig::class => \SeemannIT\Roxid\Core\ViewConfig::class,
        \OxidEsales\Eshop\Application\Model\Article::class => \SeemannIT\Roxid\Application\Model\Article::class,
        \OxidEsales\Eshop\Application\Model\BasketItem::class => \SeemannIT\Roxid\Application\Model\BasketItem::class,
        \OxidEsales\Eshop\Application\Model\Category::class => \SeemannIT\Roxid\Application\Model\Category::class,
        \OxidEsales\Eshop\Application\Model\CategoryList::class => \SeemannIT\Roxid\Application\Model\CategoryList::class,
        \OxidEsales\Eshop\Application\Model\Manufacturer::class => \SeemannIT\Roxid\Application\Model\Manufacturer::class,
        \OxidEsales\Eshop\Application\Model\RequiredAddressFields::class => \SeemannIT\Roxid\Application\Model\RequiredAddressFields::class,
    ],
    'controllers'    => [
        'ajaxbasket' => \SeemannIT\Roxid\Application\Controller\AjaxBasket::class,
    ],
    'templates'    => [
        'messages.tpl' => 'seemannit/roxid/views/messages.tpl'
    ],
    'url' => 'http://www.oxid-responsive.com'
);
