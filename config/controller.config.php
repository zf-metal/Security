<?php

namespace ZfMetal\Security;

return [
    'controllers' => [
        'factories' => [
            Controller\LoginController::class => Factory\Controller\LoginControllerFactory::class,
            Controller\RegisterController::class => Factory\Controller\RegisterControllerFactory::class,
            Controller\AdminUserController::class => Factory\Controller\AdminUserControllerFactory::class
       
        ]
    ]
];
