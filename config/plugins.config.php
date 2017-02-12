<?php

namespace ZfMetal\Security;

return [
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\Security\Controller\Plugin\BcryptEncoder::class => InvokableFactory::class,
        ],
        'aliases' => [
            'bcrypt' => \ZfMetal\Security\Controller\Plugin\BcryptEncoder::class,
        ]
    ]
];
