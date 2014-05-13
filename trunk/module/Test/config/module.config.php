<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Test\Controller\Profile' => 'Test\Controller\ProfileController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'test' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/test[/:action]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Test\Controller\profile',
                        'action'     => 'add',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'test' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-test' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);