<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MagazineRest\Controller\MagazineRest' => 'MagazineRest\Controller\MagazineRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'magazine-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/magazine-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MagazineRest\Controller\MagazineRest',
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