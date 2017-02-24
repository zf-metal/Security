<?php

namespace ZfMetal\Security;

return[
    'zf-metal-security.options' => [
        'public-register' => true,
        'email-confirmation-require' => true,
        'user-state-default' => true,
        'password-recovery' => true,
        'bcrypt-cost'=> 12,


        'redirect_strategy' => [
            'redirect_when_connected' => true,
            'redirect_to_route_connected' => 'home',
            'redirect_to_route_disconnected' => 'zf-metal.user/login',
            'append_previous_uri' => true,
            'previous_uri_query_key' => 'redirect'
        ],
    ]
];
