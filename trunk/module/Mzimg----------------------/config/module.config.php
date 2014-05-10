<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mzimg\Controller\Mzimg' => 'Mzimg\Controller\MzimgController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'mzimg' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mzimg[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Mzimg\Controller\Mzimg',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'mzimg' => __DIR__ . '/../view',
        ),
    		'template_map' => array(
    				'paginator-mzimg' => __DIR__ . '/../view/layout/slidePaginator.phtml',
    		),
    ),
);