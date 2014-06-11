<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Portcms\Controller\Portcms' => 'Portcms\Controller\PortcmsController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'portcms' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/portcms[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Portcms\Controller\Portcms',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

		'view_manager' => array(
				'template_map' => array(
						'layout/home'        => TEMPLATE_PATH . '/hairstyle/index.phtml',
						'paginator-story' => __DIR__ . '/../view/layout/slidePaginator.phtml',
				),
				'template_path_stack' => array(
						'portcms' => __DIR__ . '/../view',
				),
		),

);