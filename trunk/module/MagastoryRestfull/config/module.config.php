<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MagastoryRestfull\Controller\MagastoryRestfull' => 'MagastoryRestfull\Controller\MagastoryRestfullController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'magastoryrestfull' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/magastoryrestfull[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MagastoryRestfull\Controller\MagastoryRestfull',
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