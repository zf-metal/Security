<?php

return [
    'zfc_rbac' => [
        'guest_role' => 'guest',
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'user*' => ['admin']
            ]
        ],
        'role_provider' => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'class_name' => 'ZfMetal\Security\Entity\Role',
                'role_name_property' => 'name'
            ]
        ],
        'redirect_strategy' => [
            'redirect_when_connected' => true,
            'redirect_to_route_connected' => 'home',
            'redirect_to_route_disconnected' => 'login',
            'append_previous_uri' => true,
            'previous_uri_query_key' => 'redirect'
        ],
    ]
];
