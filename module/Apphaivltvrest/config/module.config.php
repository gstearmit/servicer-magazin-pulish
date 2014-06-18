<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Apphaivltvrest\Controller\Apphaivltvrest' => 'Apphaivltvrest\Controller\ApphaivltvrestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'apphaivltvrest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/apphaivltv-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Apphaivltvrest\Controller\Apphaivltvrest',
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