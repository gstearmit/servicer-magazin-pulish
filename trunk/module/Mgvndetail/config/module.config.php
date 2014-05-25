<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mgvndetail\Controller\Mgvndetail' => 'Mgvndetail\Controller\MgvndetailController',
        	'Mgvndetail\Controller\Upload' => 'Mgvndetail\Controller\UploadController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'mgvndetail' => array(
                'type'    => 'segment',
                'options' => array(
                  //  'route'    => '/mgvndetail[/][:controller][/][:action][/:id][/page/:page][/order_by/:order_by][/:order][/mz/:idmz]',
					 'route'    => '/mgvndetail[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by][/mz/:idmz]',
                    'constraints' => array(
                    	//'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Mgvndetail\Controller',
                        'controller' => 'Mgvndetail\Controller\Mgvndetail',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Mgvndetail' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-mgvndetail' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);