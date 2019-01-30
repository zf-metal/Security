<?php

namespace ZfMetal\Security;



return [
    'controllers' => [
        'invokables' => [
            \ZfMetal\Security\Controller\AdminController::class => \ZfMetal\Security\Controller\AdminController::class,
        ],
        'factories' => [
            Controller\InitController::class => Factory\Controller\InitControllerFactory::class,
            Controller\LoginController::class => Factory\Controller\LoginControllerFactory::class,
            Controller\RegisterController::class => Factory\Controller\RegisterControllerFactory::class,
            Controller\RecoveryController::class => Factory\Controller\RecoveryControllerFactory::class,
            Controller\AdminUserController::class => Factory\Controller\AdminUserControllerFactory::class,
            Controller\AdminRoleController::class => Factory\Controller\AdminRoleControllerFactory::class,
            Controller\AdminGroupController::class => Factory\Controller\AdminGroupControllerFactory::class,
            Controller\ProfileController::class => Factory\Controller\ProfileControllerFactory::class,
            Controller\RememberMeController::class => Factory\Controller\RememberMeControllerFactory::class,
            Controller\ImpersonateController::class => Factory\Controller\ImpersonateControllerFactory::class,
            Controller\PasswordChangeController::class => Factory\Controller\PasswordChangeControllerFactory::class
        ]
    ]
];
