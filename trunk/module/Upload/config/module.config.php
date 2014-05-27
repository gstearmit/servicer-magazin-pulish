<?php
return array(
    'controllers' => array(
        'invokables' => array(
           'Upload\Controller\Upload' => 'Upload\Controller\UploadController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'upload' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/upload[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                    	'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Upload\Controller',
                        'controller' => 'Upload\Controller\Upload',
                        'action'     => 'uploadnew',
                    ),
                ),
            ),
        ),
    		
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Upload' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'page-upload' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);