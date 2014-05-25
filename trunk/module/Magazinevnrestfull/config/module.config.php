<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Magazinevnrestfull\Controller\Magazinevnrestfull' => 'Magazinevnrestfull\Controller\MagazinevnrestfullController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'magazine-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/magazinevnrestfull[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Magazinevnrestfull\Controller\Magazinevnrestfull',
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