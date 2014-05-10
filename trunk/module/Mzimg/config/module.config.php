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
                    'route'    => '/mzimg[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
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
            'Mzimg' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-mzimg' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);