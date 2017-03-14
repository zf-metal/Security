<?php

namespace ZfMetal\Security;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\Security\Controller\Plugin\BcryptEncoder::class => InvokableFactory::class,
            \ZfMetal\Security\Controller\Plugin\StringGenerator::class => InvokableFactory::class,
            \ZfMetal\Security\Controller\Plugin\SessionManager::class => \ZfMetal\Security\Factory\Controller\Plugin\SessionManagerFactory::class,
            \ZfMetal\Security\Controller\Plugin\ModuleOptions::class => \ZfMetal\Security\Factory\Controller\Plugin\ModuleOptionsFactory::class,
        ],
        'aliases' => [
            'bcrypt' => \ZfMetal\Security\Controller\Plugin\BcryptEncoder::class,
            'stringGenerator' => \ZfMetal\Security\Controller\Plugin\StringGenerator::class,
            'sessionManager' => \ZfMetal\Security\Controller\Plugin\SessionManager::class,
            'getSecurityOptions' => \ZfMetal\Security\Controller\Plugin\ModuleOptions::class
        ]
    ]
];
