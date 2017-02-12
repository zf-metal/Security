<?php

namespace ZfMetal\Security;

use Zend\Router\Http\Literal;

// use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'zf-metal.user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user'
                ],
                'child_routes' => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/login',
                            'defaults' => [
                                'controller' => Controller\LoginController::class,
                                'action' => 'login'
                            ]
                        ]
                    ],
                    'logout' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/logout',
                            'defaults' => [
                                'controller' => Controller\LoginController::class,
                                'action' => 'logout'
                            ]
                        ]
                    ],
                    'register' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/register',
                            'defaults' => [
                                'controller' => Controller\RegisterController::class,
                                'action' => 'register'
                            ]
                        ]
                    ],
                    'recover' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/recover',
                            'defaults' => [
                                'controller' => Controller\RecoverController::class,
                                'action' => 'recover'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
