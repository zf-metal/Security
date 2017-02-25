<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RegisterControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $userRepository = $em->getRepository('ZfMetal\Security\Entity\User');

        $moduleConfig = $container->get('zf-metal-security.options');
            
        return new \ZfMetal\Security\Controller\RegisterController($em, $moduleConfig, $userRepository);
    }

}
