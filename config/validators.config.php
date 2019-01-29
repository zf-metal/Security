<?php

//TODO Los validadores no sirven, debe revisarse, se remplaza por UniqueObject (Commons)
return [
    'validators' => [
        'factories' => [
            \ZfMetal\Security\Validator\UniqueEmail::class => \Erp\Factory\Validator\UniqueEmailFactory::class,
            \ZfMetal\Security\Validator\UniqueUsername::class => \Erp\Factory\Validator\UniqueUsernameFactory::class
        ]
    ]
];