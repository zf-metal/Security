<?php
namespace ZfMetal\Security;

return [
    'factories' => [
        Adapter\Doctrine::class => Factory\Adapter\DoctrineAdapterFactory::class,
        'securetymodule.authservice' => Factory\Services\AuthServiceFactory::class,
    ],
    'aliases' => [
        \Zend\Authentication\AuthenticationService::class => 'securetymodule.authservice',
    ]
];
