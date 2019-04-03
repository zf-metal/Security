<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    
    'console' => array(
        'router' => array(
            'routes' => array(
                'initsec' => array(
                    'options' => array(
                        // add [ and ] if optional ( ex : [<doname>] )
                        'route' => 'initsec <lang>',
                        'defaults' => array(
                            'controller' => \ZfMetal\Security\Controller\InitController::class,
                            'action' => 'initsec'
                        ),
                    ),
                ),
            ),
        ),
    ),
];
