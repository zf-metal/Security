<?php

return [
    'zf-metal-datagrid.custom' => [
        'zf-metal-security-entity-role' => [
            'gridId' => 'zfmdg_role',
            'title' => "Roles",
            'title_add' => "Nuevo Rol",
            'title_edit' => "Edición de Rol",
            'multi_filter_config' => [
                "enable" => false,
                "properties_disabled" => []
            ],
            "multi_search_config" => [
                "enable" => true,
                "properties_enabled" => ['name','children','permissions']
            ],
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Security\Entity\Role::class,
                    'entityManager' => 'doctrine.entitymanager.orm_default',
                ],
            ],
            'formConfig' => [
                'columns' => \ZfMetal\Commons\Consts::COLUMNS_TWO,
                'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                'groups' => [
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_HORIZONTAL,
                        'id' => 'Role',
                        'title' => "Role",
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['name']
                    ],
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_HORIZONTAL,
                        'id' => 'ChildrenRoles',
                        'title' => "Children roles",
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['children']
                    ],
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_HORIZONTAL,
                        'id' => 'Permissions',
                        'title' => "Permissions",
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['permissions']
                    ],
                ]
            ],
            'columnsConfig' => [
                'id' => [
                    'displayName' => 'ID',
                    "hidden" => true
                ],
                'name' => [
                    'displayName' => 'Nombre',
                    'priority' => 10,
                ],
               
                'children' => [
                    'displayName' => 'Roles Hijos',
                    'hidden' => true,
                    'type' => "relational",
                    'multiSearchProperty' => "name"
                ],
                'permissions' => [
                    'displayName' => 'Permisos',
                    'hidden' => true,
                    'type' => "relational",
                    'multiSearchProperty' => "name"
                ],
               
            ],
            'crudConfig' => [
                'enable' => true,
                'side' => "right",
                'displayName' => null,
                'tdClass' => 'action_column',
                'thClass' => 'action_column',
                'add' => [
                    'enable' => true,
                    'class' => 'btn btn-primary btn-sm glyphicon glyphicon-plus cursor-pointer',
                    'value' => '',
                    'action' => 'href="/admin/roles/create"'
                ],
                'edit' => [
                    'enable' => true,
                    'class' => 'btn btn-primary btn-sm glyphicon glyphicon-edit cursor-pointer',
                    'action' => 'href="/admin/roles/edit/{{id}}"'
                ],
                'del' => [
                    'enable' => true,
                    'class' => 'btn btn-danger btn-sm glyphicon glyphicon-trash cursor-pointer',
                ],
                'view' => [
                    'enable' => true,
                    'class' => 'btn btn-success btn-sm glyphicon glyphicon-list-alt cursor-pointer',
                    'action' => 'href="/admin/roles/view/{{id}}"',
                    'value' => '',
                ],
                'manager' => [
                    'enable' => false,
                    'class' => ' glyphicon glyphicon-asterisk cursor-pointer',
                    'value' => '',
             
                ],
            ],
        ],
    ],
];
