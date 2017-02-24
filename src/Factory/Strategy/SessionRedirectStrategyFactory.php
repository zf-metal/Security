<?php

namespace ZfMetal\Security\Factory\Strategy;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SessionRedirectStrategyFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $moduleOptions = $container->get('zf-metal-security.options');
        $authenticationService = $container->get('zf-metal-security.authservice');
        $sessionManager = $container->get('zf-metal-security.session.manager');

        return new \ZfMetal\Security\Strategy\SessionRedirectStrategy($moduleOptions->getRedirectStrategy(), $authenticationService, $sessionManager);
    }

}
