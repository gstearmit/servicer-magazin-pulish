<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Storydetail\Controller\Storydetail' => 'Storydetail\Controller\StorydetailController',
        	'Storydetail\Controller\Upload' => 'Storydetail\Controller\UploadController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'storydetail' => array(
                'type'    => 'segment',
                'options' => array(
					 'route'    => '/storydetail[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                    	//'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Storydetail\Controller',
                        'controller' => 'Storydetail\Controller\Storydetail',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Storydetail' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-Storydetail' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);