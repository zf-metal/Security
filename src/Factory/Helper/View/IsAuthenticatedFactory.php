<?php

namespace ZfMetal\Security\Factory\Helper\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IsAuthenticatedFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authService = $container->get('zf-metal-security.authservice');
        return new \ZfMetal\Security\Helper\View\IsAuthenticated($authService);
    }

}
