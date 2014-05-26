<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'CatalogueRest\Controller\CatalogueRest' => 'CatalogueRest\Controller\CatalogueRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'catalogue-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/catalogue-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CatalogueRest\Controller\CatalogueRest',
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