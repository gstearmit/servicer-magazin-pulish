<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'News\Controller\News' => 'News\Controller\NewsController',
        	
        ),
    ),

    'router' => array(
        'routes' => array(
            'news' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/news[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by][/mz/:idmz]',
                    'constraints' => array(
                    	'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'News\Controller',
                        'controller' => 'News\Controller\News',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'News' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-news' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);