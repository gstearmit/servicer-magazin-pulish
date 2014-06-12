
<?php
return array(
 
    'controllers' => array(
        'invokables' => array(
            'Template\Controller\Index' => 'Template\Controller\IndexController'
        ),
    ),
		
	'router' => array(
        'routes' => array(
            'template' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/template',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Template\Controller',
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
     			'layout/home'        => TEMPLATE_ISSUS . '/index.phtml'
     	),
        'template_path_stack' => array(
            'template' => __DIR__ . '/../view',
        ),
    ),
);
