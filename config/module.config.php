<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ZfMetal\Security;

//use Zend\ServiceManager\Factory\InvokableFactory;

$config =  [
    'doctrine' => include 'doctrine.config.php',
    'router' => include 'router.config.php',
    'controllers' => include 'controller.config.php',
    'view_manager' => [
        'template_map' => [
       #     'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
       #     'security-module/login/login' => __DIR__ . '/../view/security-module/login/login.phtml',
       #     'error/404' => __DIR__ . '/../view/error/404.phtml',
       #     'error/index' => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ],
];

return array_merge($config,include 'zfc_rbac.global.php');

