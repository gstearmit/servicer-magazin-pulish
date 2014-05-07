<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Booknews\Controller\Booknews' => 'Booknews\Controller\BooknewsController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'booknews' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/booknews[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Booknews\Controller\Booknews',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'booknews' => __DIR__ . '/../view',
        ),
    		'template_map' => array(
    				'paginator-slide-book' => __DIR__ . '/../view/layout/slidePaginator.phtml',
    		),
    ),
);