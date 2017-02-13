<?php

namespace ZfMetal\Security;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'zf-metal.admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin'
                ],
                'child_routes' => [
                    'users' => [
                        'type' => Literal::class,
                        'may_terminate' => true,
                        'options' => [
                            'route' => '/users',
                            'defaults' => [
                                'controller' => Controller\AdminUserController::class,
                                'action' => 'abm'
                            ]
                        ],
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'controller' => Controller\AdminUserController::class,
                                        'action' => 'create'
                                    ]
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit/:id',
                                    'defaults' => [
                                        'controller' => Controller\AdminUserController::class,
                                        'action' => 'edit'
                                    ]
                                ],
                            ],
                            'del' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/del/:id',
                                    'defaults' => [
                                        'controller' => Controller\AdminUserController::class,
                                        'action' => 'del'
                                    ]
                                ],
                            ],
                            'view' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/view/:id',
                                    'defaults' => [
                                        'controller' => Controller\AdminUserController::class,
                                        'action' => 'view'
                                    ]
                                ],
                            ],
                            'reset-password' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/reset-password/:id',
                                    'defaults' => [
                                        'controller' => Controller\AdminUserController::class,
                                        'action' => 'reset-password'
                                    ]
                                ],
                            ],
                             'reset-password-auto' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/reset-password-auto/:id',
                                    'defaults' => [
                                        'controller' => Controller\AdminUserController::class,
                                        'action' => 'reset-password-auto'
                                    ]
                                ],
                            ]
                        ],
                    ],
                ],
            ],
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
                    'recovery' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/recovery',
                            'defaults' => [
                                'controller' => Controller\RecoveryController::class,
                                'action' => 'recovery'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
