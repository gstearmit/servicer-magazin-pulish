<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Allmagazinerestnews\Controller\Allmagazinerestnews' => 'Allmagazinerestnews\Controller\AllmagazinerestnewsController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'catalogue-url-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/catalogue-url-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Allmagazinerestnews\Controller\Allmagazinerestnews',
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