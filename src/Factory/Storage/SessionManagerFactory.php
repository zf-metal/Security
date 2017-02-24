<?php

namespace ZfMetal\Security\Factory\Session;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SessionManagerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $sessionContainter = new \ZfMetal\Security\Storage\SessionStorage('zfmetalsecurity');

        return $sessionContainter;
    }

}