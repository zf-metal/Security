<?php

return [
    'zfc_rbac' => [
        'guest_role' => 'guest',
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'impersonate' => ['admin'],
                'unimpersonate' => ['*'],
                'zf-metal.admin*' => ['admin'],
        //        'zf-metal.user/profile' => ['user','usuario']
            ]
        ],
        'role_provider' => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'class_name' => 'ZfMetal\Security\Entity\Role',
                'role_name_property' => 'name'
            ]
        ],
    ]
];
