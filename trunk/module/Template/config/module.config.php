
<?php
return array(
    
    //Bat buoc phai co khong thi se co loi
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
                    // Change this to something specific to your module
                    'route'    => '/template',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Template\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),//defaults
                ),//options
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
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
                        ),//options
                    ),//default
                ),//child_routes
            ),//users
        ),//routes
    ),//router
				
    //Bat buoc phai co thì mới load duoc View
     'view_manager' => array(    	
     	'template_map' => array(
     		'layout/home'        => TEMPLATE_PATH . '/hairstyle/index.phtml'
     	),
        'template_path_stack' => array(
            'template' => __DIR__ . '/../view',
        ),
    ),
);
