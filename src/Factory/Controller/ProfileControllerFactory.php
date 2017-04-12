<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProfileControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authService = $container->get('zf-metal-security.authservice');
        $em = $container->get('doctrine.entitymanager.orm_default');
        $userRepository = $em->getRepository('ZfMetal\Security\Entity\User');
        return new \ZfMetal\Security\Controller\ProfileController($em,$authService, $userRepository);
    }

}
