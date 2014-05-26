<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'LibrarybooksRest\Controller\LibrarybooksRest' => 'LibrarybooksRest\Controller\LibrarybooksRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'librarybooks-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/librarybooks-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'LibrarybooksRest\Controller\LibrarybooksRest',
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