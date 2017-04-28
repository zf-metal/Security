<?php

namespace ZfMetal\Security\Factory\Services;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\Storage\Session;

class RememberMeAuthServicesFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $storage = new Session('ZfMetal\Security');
        $adapter = $container->get(\ZfMetal\Security\Adapter\RememberMe::class);
        
        $authServices = new \Zend\Authentication\AuthenticationService($storage, $adapter);
        return $authServices;
    }

}
