<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Magazinevnrest\Controller\Magazinevnrest' => 'Magazinevnrest\Controller\MagazinevnrestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'magazinevietnam-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/magazinevietnam-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Magazinevnrest\Controller\Magazinevnrest',
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