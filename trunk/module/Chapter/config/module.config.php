<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Chapter\Controller\Chapter' => 'Chapter\Controller\ChapterController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'chapter' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/chapter[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Chapter\Controller\Chapter',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Chapter' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-chapter' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),

);