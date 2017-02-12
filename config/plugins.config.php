<?php

namespace ZfMetal\Security;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\Security\Controller\Plugin\BcryptEncoder::class => InvokableFactory::class,
            \ZfMetal\Security\Controller\Plugin\StringGenerator::class => InvokableFactory::class,
        ],
        'aliases' => [
            'bcrypt' => \ZfMetal\Security\Controller\Plugin\BcryptEncoder::class,
            'stringGenerator' => \ZfMetal\Security\Controller\Plugin\StringGenerator::class,
        ]
    ]
];
