<?php

namespace ZfMetal\Security;

return [
    'controllers' => [
        'factories' => [
            Controller\LoginController::class => Factory\Controller\LoginControllerFactory::class,
            Controller\RegisterController::class => Factory\Controller\RegisterControllerFactory::class,
            Controller\RecoveryController::class => Factory\Controller\RecoveryControllerFactory::class,
            Controller\AdminUserController::class => Factory\Controller\AdminUserControllerFactory::class,
            Controller\AdminRoleController::class => Factory\Controller\AdminRoleControllerFactory::class,

        ]
    ]
];
