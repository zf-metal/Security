<?php

namespace ZfMetal\Security\Factory\Services;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\Storage\Session;
use ZfMetal\Security\Services\Impersonate;

class ImpersonateFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $adapter = $container->get(\ZfMetal\Security\Adapter\Doctrine::class);


        //USER REPOSITORY
        $em = $container->get("doctrine.entitymanager.orm_default");
        $userRepository = $em->getRepository('ZfMetal\Security\Entity\User');

        /** @var \ZfMetal\Security\Options\ModuleOptions $securityOptions */
        $securityOptions = $container->get('zf-metal-security.options');


        $storage = new Session(Impersonate::class, 'impersonator');

        $authService = $container->get('zf-metal-security.authservice');

        $impersonate = new Impersonate(
            $authService,
            $securityOptions,
            $userRepository,
            $storage,
            $securityOptions->getImpsersonateUserAsObject()
        );

        return $impersonate;
    }

}
