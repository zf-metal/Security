<?php

namespace ZfMetal\Security;

use Gedmo\Tree\Strategy;

return [
        'factories' => [
            Adapter\Doctrine::class => Factory\Adapter\DoctrineAdapterFactory::class,
            'zf-metal-security.authservice' => Factory\Services\AuthServiceFactory::class,
            'zf-metal-security.options' => Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\Security\Stragety\SessionRedirectStrategy::class => 'ZfcRbac\Factory\RedirectStrategyFactory',
        ],
        'aliases' => [
            \Zend\Authentication\AuthenticationService::class => 'zf-metal-security.authservice',
        ]
];

