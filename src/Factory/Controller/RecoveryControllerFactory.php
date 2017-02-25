<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RecoveryControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $userRepository = $em->getRepository('ZfMetal\Security\Entity\User');

        //INIT FORM AND FILTER
        $form = new \ZfMetal\Security\Form\Recover();
        $emailExist = new \ZfMetal\Security\Validator\EmailExist(["userRepository" => $userRepository]);
        $filter = new \ZfMetal\Security\Form\Filter\RecoverFilter($emailExist);
        $form->setInputFilter($filter);

        return new \ZfMetal\Security\Controller\RecoveryController($userRepository, $form);
    }

}
