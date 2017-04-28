<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LoginControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authService = $container->get('zf-metal-security.authservice');
        $em = $container->get('doctrine.entitymanager.orm_default');
        return new \ZfMetal\Security\Controller\LoginController($authService,$em);
    }

}
