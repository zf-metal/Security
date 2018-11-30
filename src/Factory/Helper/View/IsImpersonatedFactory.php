<?php

namespace ZfMetal\Security\Factory\Helper\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Security\Services\Impersonate;

class IsImpersonatedFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $impersonate = $container->get(Impersonate::class);
        return new \ZfMetal\Security\Helper\View\IsImpersonated($impersonate);
    }

}
