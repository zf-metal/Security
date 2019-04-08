<?php

namespace ZfMetal\Security\Factory\Services;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\Storage\Session;
use ZfMetal\Security\Services\AuthenticationService;

class AuthServiceFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $storage = new Session('ZfMetal\Security');
        $adapter = $container->get(\ZfMetal\Security\Adapter\Doctrine::class);
        $em = $container->get("doctrine.entitymanager.orm_default");

        $authServices = new AuthenticationService($storage, $adapter, $em);
        return $authServices;
    }

}
