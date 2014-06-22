<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Wattpad\Controller\Wattpad' => 'Wattpad\Controller\WattpadController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'wattpad' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/wattpad[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Wattpad\Controller\Wattpad',
                        'action'     => 'rssget',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Wattpad' => __DIR__ . '/../view',
        ),
    		'template_map' => array(
    				'paginator-wattpad' => __DIR__ . '/../view/layout/slidePaginator.phtml',
    		),
    		'strategies' => array(
    				'ViewJsonStrategy',
    		),
    ),
);