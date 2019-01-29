<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Security\Form\Register;

class RegisterControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $userRepository = $em->getRepository('ZfMetal\Security\Entity\User');
        $form = $container->get('FormElementManager')->get(Register::class);
        return new \ZfMetal\Security\Controller\RegisterController($em, $form);
    }

}
