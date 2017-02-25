<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AdminRoleControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        
        //ENTITY MANAGER
        $em = $container->get('doctrine.entitymanager.orm_default');
        //USER REPOSITORY
        $roleRepository = $em->getRepository('ZfMetal\Security\Entity\Role');
        $moduleConfig = $container->get('zf-metal-security.options');
        
        /* @var $dataGrid \ZfMetal\Security\DataGrid\DataGrid */
        $dataGrid = $container->get(\ZfMetal\Security\DataGrid\DataGrid::class);

        //QB
        $qb = $em->createQueryBuilder()
                ->select("u")
                ->from(\ZfMetal\Security\Entity\Role::class, "u")
                ->orderBy("u.id","asc");

        $dataGrid->setQb($qb);
        
        $dataGrid->setRecordPerPage(10);
        
        return new \ZfMetal\Security\Controller\AdminRoleController($em, $dataGrid, $moduleConfig, $roleRepository);
    }

}
