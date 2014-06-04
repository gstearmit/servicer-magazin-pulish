<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AlbumRest\Controller\AlbumRest' => 'AlbumRest\Controller\AlbumRestController',
        	'AlbumRest\Controller\AlbumClient' => 'AlbumRest\Controller\AlbumClientController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'album-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/album-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AlbumRest\Controller\AlbumRest',
                    ),
                ),
            ),
        ),
    	
    		'may_terminate' => true,
    		'child_routes' => array(
    				'client' => array(
    						'type'    => 'Segment',
    						'options' => array(
    								'route'    => '/client[/:action]',
    								'constraints' => array(
    										'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
    								),
    								'defaults' => array(
    										'controller' => 'AlbumClient',
    										'action'     => 'index'
    								),
    						),
    				),
    		),
    		
    		
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);