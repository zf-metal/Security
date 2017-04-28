<?php

namespace ZfMetal\Security;

use Gedmo\Tree\Strategy;
use Prophecy\Comparator\Factory;

return [
    'service_manager' => [
        'factories' => [
            //Adapters
            \ZfMetal\Security\Adapter\Doctrine::class => \ZfMetal\Security\Factory\Adapter\DoctrineAdapterFactory::class,
            \ZfMetal\Security\Adapter\RememberMe::class => \ZfMetal\Security\Factory\Adapter\RememberMeFactory::class,
            // Auth Services
            'zf-metal-security.authservice' => \ZfMetal\Security\Factory\Services\AuthServiceFactory::class,
            'zf-metal-security.authservice-remember-me' => \ZfMetal\Security\Factory\Services\RememberMeAuthServicesFactory::class,
            // Others
            'zf-metal-security.options' => \ZfMetal\Security\Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\Security\Strategy\SessionRedirectStrategy::class => \ZfMetal\Security\Factory\Strategy\SessionRedirectStrategyFactory::class,
            \ZfMetal\Security\DataGrid\DataGrid::class => \ZfMetal\Security\Factory\DataGrid\DataGridFactory::class,
            'zf-metal-security.session.manager' => \ZfMetal\Security\Factory\Storage\SessionManagerFactory::class,
        ],
        'aliases' => [
            \Zend\Authentication\AuthenticationService::class => 'zf-metal-security.authservice',
            'zf-metal-security.session-redirect-stretegy' => \ZfMetal\Security\Strategy\SessionRedirectStrategy::class,
            
        ]
    ]
];

