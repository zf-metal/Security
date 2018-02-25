<?php

return [
    'zf-metal-datagrid.exports' => [
        'export-zf-metal-security-entity-user' => [
            'fileName' => 'Usuarios',
            'columnsConfig' => [
                'id' => [
                    'displayName' => 'ID',
                ],
                'name' => [
                    'displayName' => 'Nombre',
                    'priority' => 10,
                ],
                'username' => [
                    'displayName' => 'Usuario',
                    'priority' => 20,
                ],
                'email' => [
                    'displayName' => 'Email',
                    'priority' => 30,
                ],
                'active' => [
                    'type' => "boolean",
                    'valueWhenTrue' => "Activo",
                    'valueWhenFalse' => "Inactivo"
                ],
                'password' => [
                    'displayName' => 'Password',
                    'hidden' => true,
                ],
                'img' => [
                    'displayName' => 'Img',
                    'hidden' => true,
                ],
                'roles' => [
                    'displayName' => 'Roles',
                    'hidden' => true,
                    'type' => "relational",
                    'multiSearchProperty' => "name"
                ],
                'groups' => [
                    'displayName' => 'Grupos',
                    'hidden' => true,
                    'type' => "relational",
                ],
                'createdAt' => [
                    'displayName' => 'Creado en Fecha',
                    'type' => "datetime",
                    'format' => 'Y-m-d H:i:s',
                ],
                'updatedAt' => [
                    'displayName' => 'Ultima Actualización',
                    'type' => "datetime",
                    'format' => 'Y-m-d H:i:s',
                ],
            ],
        ],
    ],
    'zf-metal-datagrid.custom' => [
        'zf-metal-security-entity-user' => [
            'gridId' => 'zfmdg_usuario',
            'title' => "Usuarios",
            'title_add' => "Nuevo Usuario",
            'title_edit' => "Edición de Usuario",
            'export_config' => [
                'export_to_excel' => [
                    'enable' => true,
                    'key' => 'export-zf-metal-security-entity-user',
                    'btn_class' => 'btn btnCustom fa fa-file-excel-o',
                    'btn_value' => 'Excel',
                    'btn_tag' => 'button',
                ],
            ],
            'multi_filter_config' => [
                "enable" => false,
                "properties_disabled" => []
            ],
            "multi_search_config" => [
                "enable" => true,
                "properties_enabled" => ['name', 'username', 'email', 'roles', 'groups']
            ],
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Security\Entity\User::class,
                    'entityManager' => 'doctrine.entitymanager.orm_default',
                ],
            ],
            'formConfig' => [
                'columns' => \ZfMetal\Commons\Consts::COLUMNS_TWO,
                'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                'groups' => [
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_HORIZONTAL,
                        'id' => 'User',
                        'title' => "User",
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_TWO,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['name', 'username', 'email', 'password']
                    ],
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_VERTICAL,
                        'id' => 'enableUser',
                        'title' => 'Enable/Disable User',
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['active']
                    ],
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_VERTICAL,
                        'id' => 'Roles',
                        'title' => 'Roles',
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['roles']
                    ],
                    [
                        'type' => \ZfMetal\Commons\Options\FormGroupConfig::TYPE_VERTICAL,
                        'id' => 'Groups',
                        'title' => 'Groups',
                        'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                        'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                        'fields' => ['groups']
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
                'username' => [
                    'displayName' => 'Usuario',
                    'priority' => 20,
                ],
                'email' => [
                    'displayName' => 'Email',
                    'priority' => 30,
                ],
                'active' => [
                    'type' => "boolean",
                    'valueWhenTrue' => "<i class='text-success glyphicon glyphicon-ok'></i>",
                    'valueWhenFalse' => "<i class='text-danger glyphicon glyphicon-remove'></i>"
                ],
                'password' => [
                    'displayName' => 'Password',
                    'hidden' => true,
                ],
                'img' => [
                    'displayName' => 'Img',
                    'hidden' => true,
                ],
                'roles' => [
                    'displayName' => 'Roles',
                    'hidden' => true,
                    'type' => "relational",
                    'multiSearchProperty' => "name"
                ],
                'groups' => [
                    'displayName' => 'Grupos',
                    'hidden' => true,
                    'type' => "relational",
                    'multiSearchProperty' => "name"
                ],
                'createdAt' => [
                    'displayName' => 'Creado en Fecha',
                    'type' => "datetime",
                    'format' => 'Y-m-d H:i:s',
                    'hidden' => true,
                ],
                'updatedAt' => [
                    'displayName' => 'Ultima Actualización',
                    'type' => "datetime",
                    'format' => 'Y-m-d H:i:s',
                    'hidden' => true,
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
                    'action' => 'href="/admin/users/create"'
                ],
                'edit' => [
                    'enable' => true,
                    'class' => 'btn btn-primary btn-sm  glyphicon glyphicon-edit cursor-pointer',
                    'action' => 'href="/admin/users/edit/{{id}}"'
                ],
                'del' => [
                    'enable' => true,
                    'class' => 'btn btn-danger btn-sm  glyphicon glyphicon-trash cursor-pointer',
                ],
                'view' => [
                    'enable' => true,
                    'class' => 'btn btn-success btn-sm  glyphicon glyphicon-list-alt cursor-pointer',
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
