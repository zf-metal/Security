<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RegisterControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $userRepository = $em->getRepository('ZfMetal\Security\Entity\User');

        return new \ZfMetal\Security\Controller\RegisterController($em, $userRepository);
    }

}
