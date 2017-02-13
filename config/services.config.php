<?php

namespace ZfMetal\Security;

use Gedmo\Tree\Strategy;

return [
    'service_manager' => [
        'factories' => [
            Adapter\Doctrine::class => Factory\Adapter\DoctrineAdapterFactory::class,
            'zf-metal-security.authservice' => Factory\Services\AuthServiceFactory::class,
            'zf-metal-security.options' => Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\Security\Stragety\SessionRedirectStrategy::class => 'ZfcRbac\Factory\RedirectStrategyFactory',
            \ZfMetal\Security\DataGrid\DataGrid::class => Factory\DataGrid\DataGridFactory::class,
        ],
        'aliases' => [
            \Zend\Authentication\AuthenticationService::class => 'zf-metal-security.authservice',
        ]
    ]
];

