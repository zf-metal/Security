<?php

namespace ZfMetal\Security\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SessionManagerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $sessionContainter = new \ZfMetal\Security\Session\StorageSession('zfmetalsecurity');

        return new \ZfMetal\Security\Controller\Plugin\SessionManager($sessionContainter);
    }

}
