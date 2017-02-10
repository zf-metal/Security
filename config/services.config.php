<?php

namespace ZfMetal\Security;

return [
    'services' => [
        'factories' => [
            Adapter\Doctrine::class => Factory\Adapter\DoctrineAdapterFactory::class,
            'zf-metal-security.authservice' => Factory\Services\AuthServiceFactory::class,
            'zf-metal-security.options' => Factory\Options\ModuleOptionsFactory::class,
        ],
        'aliases' => [
            \Zend\Authentication\AuthenticationService::class => 'zf-metal-security.authservice',
        ]
    ]
];

