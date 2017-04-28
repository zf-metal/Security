<?php

namespace ZfMetal\Security\Factory\Adapter;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class RememberMeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        return new \ZfMetal\Security\Adapter\RememberMe($em);
    }
}