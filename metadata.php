<?php

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'abicorios_installment',
    'title'       => [
        'de' => 'Abicorios - Ratenzahlung',
        'en' => 'Abicorios - Installment',
    ],
    'description' => [
        'de' => 'Ratenzahlung für die Produkte einrichten.',
        'en' => 'Set up installments for the products.',
    ],
    'thumbnail'   => '',
    'version'     => '1.0',
    'author'      => 'Abicorios',
    'url'         => 'https://github.com/abicorios/OxidEshopInstallment',
    'email'       => 'yaroslav.moroz91@gmail.com',
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\Article::class => \abicorios\OxidEshopInstallment\Model\Article::class,
        \OxidEsales\Eshop\Application\Controller\Admin\ArticleMain::class => \abicorios\OxidEshopInstallment\Controller\Admin\ArticleMain::class,
    ],
    'blocks'      => [
        [
            'template' => 'article_main.tpl',
            'block'    => 'admin_article_main_extended',
            'file'     => 'views/admin/blocks/article_main__admin_article_main_extended.tpl',
            'position' => '1',
        ],
        [
            'template' => 'page/details/inc/productmain.tpl',
            'block'    => 'details_productmain_shortdesc',
            'file'     => 'views/blocks/productmain__details_productmain_shortdesc.tpl',
            'position' => '1',
        ]
    ],
    'settings'    => [
    ],
];
