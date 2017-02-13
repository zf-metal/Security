<?php

namespace ZfMetal\Security;

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],

    ],
    'view_helpers' => [
        'factories' => [
            'isAuthenticated' => Factory\Helper\View\IsAuthenticatedFactory::class,
        ],
    ]
];
