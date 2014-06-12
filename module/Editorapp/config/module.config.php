
<?php
return array(
 
    'controllers' => array(
        'invokables' => array(
            'Editorapp\Controller\Index' => 'Editorapp\Controller\IndexController'
        ),
    ),
		
	'router' => array(
        'routes' => array(
            'editorapp' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/editorapp',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Editorapp\Controller',
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
     			'layout/editor'        => Editorapp_PATH . '/index.phtml'
     	),
        'template_path_stack' => array(
            'editorapp' => __DIR__ . '/../view',
        ),
    ),
);
