<?php
return[
    'zf-metal-security.options' => [
        'public_register' => true,
        'role_default' => 'guest',
        'email_confirmation_require' => true,
        'mail_from' => "info.zfmetal@gmail.com",
        'user_state_default' => true,
        'password_recovery' => true,
        'password_column_reset' => true,
        'password_column_value' => "<a href='/admin/users/reset-password/{{id}}'>password</a>",
        'bcrypt_cost' => 12,
        'profile_picture_path' => __DIR__ . '/../../../../public/img/profile/',
        'profile_picture_path_relative' => '/img/profile/',
        'saved_user_redirect_route' => 'zf-metal.admin/users/view',
        'redirect_strategy' => [
            'redirect_when_connected' => true,
            'redirect_to_route_connected' => 'home',
            'redirect_to_route_disconnected' => 'zf-metal.user/login',
            'append_previous_uri' => true,
            'previous_uri_query_key' => 'redirect',
        ],
        'remember_me' => true,
        'check_db' => true, //Set false after initiate DB
        'edit_email_user' => false,
    ],
];
