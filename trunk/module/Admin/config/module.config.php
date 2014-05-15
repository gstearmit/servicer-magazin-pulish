<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
        	'Admin\Controller\Upload' => 'Admin\Controller\UploadController'
        ),
    ),
	'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    //'route'    => '/album[/:controller][/:action][/][:id]',
                	'route'    => '/admin[/][:controller][/][:action][/][id/:id]',
                    'constraints' => array(
                    	'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' 	 => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     	 => '[0-9]+',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Admin\Controller',//Khong co namespace thi se xay ra loi
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

        ),
    ),
	
    //Bat buoc phai co thì mới load duoc View
    'view_manager' => array(    	
    	/* 'template_map' => array(
    		'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
    	), */
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view'
        ),
    ),
	'translator' => array(
		'locale' => 'en_US',
			'translation_file_patterns' => array(
				array(
					'type'     => 'gettext',
					'base_dir' => __DIR__ . '/../language',
					'pattern'  => '%s.mo',
				),
			),
		), 
);
