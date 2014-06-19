<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Appzf2rest\Controller\Appzf2rest' => 'Appzf2rest\Controller\Appzf2restController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'appzf2rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/appzf2-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Appzf2rest\Controller\Appzf2rest',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);