<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ManastoryRest\Controller\ManastoryRest' => 'ManastoryRest\Controller\ManastoryRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'manastoryrest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/manastoryrest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ManastoryRest\Controller\ManastoryRest',
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