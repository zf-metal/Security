<?php

return [
    'form_elements' => [
        'factories' => [
            \ZfMetal\Security\Form\User::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Security\Form\Register::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],

    ],
];