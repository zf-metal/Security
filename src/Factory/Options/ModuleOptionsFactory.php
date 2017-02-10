<?php

namespace ZfMetal\Security\Factory\Options;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class ModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
         $config = $container->get('Config');
         
         return new \ZfMetal\Security\Options\ModuleOptions(isset($config['zf-metal-security.options']) ? $config['zf-metal-security.options'] : array());
    }

}
