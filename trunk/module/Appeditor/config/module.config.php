
<?php
return array(
 
    'controllers' => array(
        'invokables' => array(
            'Appeditor\Controller\Index' => 'Appeditor\Controller\IndexController'
        ),
    ),
		
	'router' => array(
        'routes' => array(
            'appeditor' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/appeditor',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Appeditor\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),//constraints
                            'defaults' => array(
                            ),//defaults
                        ),
                    ),
                ),
            ),//users
        ),//routes
    ),//router
				
   
     'view_manager' => array(    	
     	'template_map' => array(
     			'layout/appeditor'        => Appeditor_PATH . '/index.phtml'
     	),
        'template_path_stack' => array(
            'appeditor' => __DIR__ . '/../view',
        ),
    ),
);
