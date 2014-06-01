<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Newdetail\Controller\Newdetail' => 'Newdetail\Controller\NewdetailController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'newdetail' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/newdetail[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'newdetail\Controller\newdetail',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'newdetail' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
	'doctrine' => array(
    'driver' => array(
      __NAMESPACE__ . '_driver' => array(
        'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
        'cache' => 'array',
        'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
      ),
      'orm_default' => array(
        'drivers' => array(
          __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
        )
      )
    )
  ),
);