<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Apphaivlcomrest\Controller\Apphaivlcomrest' => 'Apphaivlcomrest\Controller\ApphaivlcomrestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'apphaivlcomrest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/apphaivlcom-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Apphaivlcomrest\Controller\Apphaivlcomrest',
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