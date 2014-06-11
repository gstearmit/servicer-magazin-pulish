
<?php
return array(
 
    'controllers' => array(
        'invokables' => array(
            'Portcms\Controller\Index' => 'Portcms\Controller\IndexController'
        ),
    ),
		
	'router' => array(
        'routes' => array(
            'portcms' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/portcms',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Portcms\Controller',
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
     		'layout/home'        => PORTCMS_PATH . '/portcms/index.phtml'
     	),
        'template_path_stack' => array(
            'portcms' => __DIR__ . '/../view',
        ),
    ),
);
