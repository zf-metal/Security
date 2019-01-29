<?php
/**
 * Zend Framework Application.
 */

namespace Erp\Factory\Validator;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Security\Validator\UniqueEmail;
use ZfMetal\Security\Validator\UniqueUsername;


class UniqueUsernameFactory implements FactoryInterface
{

    /**
     * Factory for UniqueObject.
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  array $options
     * @return UniqueObject
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $entityManager = $container->get("doctrine.entitymanager.orm_default");
        return new UniqueUsername($entityManager);
    }

}