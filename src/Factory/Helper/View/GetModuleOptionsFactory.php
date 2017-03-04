<?php

namespace ZfMetal\Security\Factory\Helper\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GetModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $moduleOptions = $container->get('zf-metal-security.options');
        return new \ZfMetal\Security\Helper\View\GetModuleOptions($moduleOptions);
    }

}
