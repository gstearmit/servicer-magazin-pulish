<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'NewdetailRest\Controller\NewdetailRest' => 'NewdetailRest\Controller\NewdetailRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'newdetail-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/newdetail-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NewdetailRest\Controller\NewdetailRest',
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