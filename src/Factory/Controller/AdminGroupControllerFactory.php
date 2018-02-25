<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AdminGroupControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");

        //USER REPOSITORY
        $groupRepository = $em->getRepository('ZfMetal\Security\Entity\Group');

        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $container->build("zf-metal-datagrid", ["customKey" => "zf-metal-security-entity-group"]);

        $moduleConfig = $container->get('zf-metal-security.options');
        
        return new \ZfMetal\Security\Controller\AdminGroupController($em, $grid, $moduleConfig, $groupRepository);
    }

}
