<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Security\Services\Impersonate;

class ImpersonateControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $impersonate = $container->get(Impersonate::class);
        $moduleOptions = $container->get('zf-metal-security.options');
        return new \ZfMetal\Security\Controller\ImpersonateController($moduleOptions,$impersonate);
    }

}
