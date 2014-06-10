<?php
return array(
    'controllers' => array(
        'invokables' => array(
           'Uploadmagazine\Controller\Uploadmagazine' => 'Uploadmagazine\Controller\UploadmagazineController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'uploadmagazine' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/uploadmagazinepublish[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                    	'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Uploadmagazine\Controller',
                        'controller' => 'Uploadmagazine\Controller\Uploadmagazine',
                        'action'     => 'uploadnew',
                    ),
                ),
            ),
        ),
    		
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Uploadmagazine' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-upload' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);