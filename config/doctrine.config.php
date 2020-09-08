<?php

namespace ZfMetal\Security;

use Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter;
use Gedmo\SoftDeleteable\SoftDeleteableListener;

return [
    'doctrine' => [
        'driver' => array(
            __NAMESPACE__ => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Entity'
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__
                )
            )
        ),
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    // pick any listeners you need
                    'Gedmo\Timestampable\TimestampableListener',
                    SoftDeleteableListener::class
                ),
            ),

        ),
        'configuration' => [
            'orm_default' => [
                'filters' => [
                    'soft-deletable' => SoftDeleteableFilter::class,
                ],
            ],
        ],
    ]
];
