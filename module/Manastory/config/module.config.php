<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Manastory\Controller\Manastory' => 'Manastory\Controller\ManastoryController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'manastory' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/manastory[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'manastory\Controller\manastory',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'manastory' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginatorstory' => __DIR__ . '/../view/layout/slidePaginator.phtml',
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