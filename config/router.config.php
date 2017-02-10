<?php

namespace ZfMetal\Security;

use Zend\Router\Http\Literal;

// use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user/login',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user/logout',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'logout'
                    ]
                ]
            ]
        ]
    ]
];
