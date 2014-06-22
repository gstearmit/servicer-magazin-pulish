<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Appmincecraftrest\Controller\Appmincecraftrest' => 'Appmincecraftrest\Controller\AppmincecraftrestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'appmincecraftrest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/appmincecraft-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Appmincecraftrest\Controller\Appmincecraftrest',
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