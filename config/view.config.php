<?php

namespace ZfMetal\Security;

return [
    'view_manager' => [
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error' => __DIR__ . '/../view/error/index.phtml',
            '404' => __DIR__ . '/../view/error/404.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'isAuthenticated' => Factory\Helper\View\IsAuthenticatedFactory::class,
            'isImpersonated' => Factory\Helper\View\IsImpersonatedFactory::class,
            'identity' => Factory\Helper\View\IsAuthenticatedFactory::class,
            'getSecurityOptions' => Factory\Helper\View\GetModuleOptionsFactory::class,
        ],
        'invokables' => [
            'notyFlash' => Helper\View\NotyFlash::class,
        ]
    ],
    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format' => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string' => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        )
    ),
];
