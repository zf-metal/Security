<?php

namespace ZfMetal\Security\Factory\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RbacListenerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authorizationService = $container->get('ZfcRbac\Service\AuthorizationService');

        return new \ZfMetal\Security\Listener\RbacListener($authorizationService);
    }

}
