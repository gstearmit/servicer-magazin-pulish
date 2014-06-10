<?php
return array(
    'controllers' => array(
        'invokables' => array(
           'Uploadmagazinevietnam\Controller\Uploadmagazinevietnam' => 'Uploadmagazinevietnam\Controller\UploadmagazinevietnamController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'uploadmagazinevietnam' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/uploadmagazinevietnampublish[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                    	'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Uploadmagazinevietnam\Controller',
                        'controller' => 'Uploadmagazinevietnam\Controller\Uploadmagazinevietnam',
                        'action'     => 'uploadnew',
                    ),
                ),
            ),
        ),
    		
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Uploadmagazinevietnam' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-upload' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);