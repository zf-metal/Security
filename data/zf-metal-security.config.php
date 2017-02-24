<?php

return[
    'zf-metal-security.options' => [
        'public-register' => true,
        'password-recovery' => true,
        'bcrypt-cost'=> 12,

        'redirect_strategy' => [
            'redirect_when_connected' => true,
            'redirect_to_route_connected' => 'home',
            'redirect_to_route_disconnected' => 'login',
            'append_previous_uri' => true,
            'previous_uri_query_key' => 'redirect'
        ],
    ]
];
