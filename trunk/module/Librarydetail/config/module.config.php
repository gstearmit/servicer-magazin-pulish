<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Librarydetail\Controller\Librarydetail' => 'Librarydetail\Controller\LibrarydetailController',
        	'Librarydetail\Controller\Upload' => 'Librarydetail\Controller\UploadController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'librarydetail' => array(
                'type'    => 'segment',
                'options' => array(
                  //  'route'    => '/librarydetail[/][:controller][/][:action][/:id][/page/:page][/order_by/:order_by][/:order][/mz/:idmz]',
					 'route'    => '/librarydetail[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by][/mz/:idmz]',
                    'constraints' => array(
                    	//'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Librarydetail\Controller',
                        'controller' => 'Librarydetail\Controller\Librarydetail',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    		'uploadlib' => array (
    				'type' => 'segment',
    				'options' => array (
    						'route'    => '/uploadlibrarydetail[/:action][/:id]',
    						'constraints' => array(
    								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
    								'id'     => '[0-9]+',
    						),
    						'defaults' => array (
    								'__NAMESPACE__' => 'Librarydetail\Controller',
    								'controller' => 'Librarydetail\Controller\Upload',
    								'action' => 'uploadnew'
    						)
    				)
    		),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Librarydetail' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-librarydetail' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);