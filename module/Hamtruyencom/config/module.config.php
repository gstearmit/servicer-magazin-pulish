<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Hamtruyencom\Controller\Hamtruyencom' => 'Hamtruyencom\Controller\HamtruyencomController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'hamtruyencom' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/hamtruyencom[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Hamtruyencom\Controller\Hamtruyencom',
                        'action'     => 'rssget',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Hamtruyencom' => __DIR__ . '/../view',
        ),
    		'template_map' => array(
    				'paginator-hamtruyencom' => __DIR__ . '/../view/layout/slidePaginator.phtml',
    		),
    		'strategies' => array(
    				'ViewJsonStrategy',
    		),
    ),
);