<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Librarybooksrestfull\Controller\Librarybooksrestfull' => 'Librarybooksrestfull\Controller\LibrarybooksrestfullController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'librarybooksrestfull' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/librarybooksrestfull[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Librarybooksrestfull\Controller\Librarybooksrestfull',
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