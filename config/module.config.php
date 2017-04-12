<?php

namespace ZfMetal\Security;

return array_merge(
        include 'doctrine.config.php', 
        include 'zfc_rbac.config.php', 
        include 'router.config.php', 
        include 'controller.config.php',
        include 'plugins.config.php',
        include 'view.config.php', 
        include 'services.config.php',
        include 'options.config.php'
);