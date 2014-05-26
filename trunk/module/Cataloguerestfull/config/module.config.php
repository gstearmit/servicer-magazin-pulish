<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Cataloguerestfull\Controller\Cataloguerestfull' => 'Cataloguerestfull\Controller\CataloguerestfullController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'catalogue-restfull' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/cataloguerestfull[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cataloguerestfull\Controller\Cataloguerestfull',
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