<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mzimg\Controller\Mzimg' => 'Mzimg\Controller\MzimgController',
        	'Mzimg\Controller\Upload' => 'Mzimg\Controller\UploadController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'mzimg' => array(
                'type'    => 'segment',
                'options' => array(
                  //  'route'    => '/mzimg[/][:controller][/][:action][/:id][/page/:page][/order_by/:order_by][/:order][/mz/:idmz]',
					 'route'    => '/mzimg[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by][/mz/:idmz]',
                    'constraints' => array(
                    	//'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Mzimg\Controller',
                        'controller' => 'Mzimg\Controller\Mzimg',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Mzimg' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-mzimg' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);