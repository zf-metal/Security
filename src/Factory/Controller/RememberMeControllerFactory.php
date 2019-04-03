<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RememberMeControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authService = $container->get('zf-metal-security.authservice-remember-me');
        return new \ZfMetal\Security\Controller\RememberMeController($authService);
    }

}
