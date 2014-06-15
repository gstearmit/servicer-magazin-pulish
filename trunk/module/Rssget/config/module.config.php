<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Rssget\Controller\Rssget' => 'Rssget\Controller\RssgetController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'rssget' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/rssget[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Rssget\Controller\Rssget',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Rssget' => __DIR__ . '/../view',
        ),
    		'template_map' => array(
    				'paginator-Rssget' => __DIR__ . '/../view/layout/slidePaginator.phtml',
    		),
    		'strategies' => array(
    				'ViewJsonStrategy',
    		),
    ),
);