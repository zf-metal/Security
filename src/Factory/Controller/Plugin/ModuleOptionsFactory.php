<?php

namespace ZfMetal\Security\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $moduleOptions = $container->get('zf-metal-security.options');
        return new \ZfMetal\Security\Controller\Plugin\ModuleOptions($moduleOptions);
    }

}
