<?php

namespace ZfMetal\Security\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AdminUserControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $container->build("zf-metal-datagrid", ["customKey" => "zf-metal-security-entity-user"]);

        $moduleConfig = $container->get('zf-metal-security.options');

        $ZfcRbacOptions = $container->get('ZfcRbac\Options\ModuleOptions');


        return new \ZfMetal\Security\Controller\AdminUserController($em, $grid, $moduleConfig, $em->getRepository(\ZfMetal\Security\Entity\User::class),$ZfcRbacOptions);
    }

}
