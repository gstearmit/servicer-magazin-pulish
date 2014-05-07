<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MagazinePublishRest\Controller\MagazinePublishRest' => 'MagazinePublishRest\Controller\MagazinePublishRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'magazinepublish-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/magazinepublish-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MagazinePublishRest\Controller\MagazinePublishRest',
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