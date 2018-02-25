<?php

namespace ZfMetal\Security;

return array_merge_recursive(
    include 'doctrine.config.php',
    include 'zfc_rbac.config.php',
    include 'router.config.php',
    include 'route-console.config.php',
    include 'controller.config.php',
    include 'plugins.config.php',
    include 'view.config.php',
    include 'services.config.php',
    include 'options.config.php',
    include 'zfm-datagrid.user.config.php',
    include 'zfm-datagrid.role.config.php',
    include 'zfm-datagrid.group.config.php'
);