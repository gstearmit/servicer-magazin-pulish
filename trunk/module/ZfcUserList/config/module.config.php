<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'zfcuserlist' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'zfcuserlist' => 'ZfcUserList\Controller\UserListController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcuser' => array(
                'child_routes' => array(
                    'zfcuserlist' => array(
                        'type' => 'Segment',
                        'options' =>array(
                            'route' => '/list[/:p]',
                            'defaults' => array(
                                'controller' => 'zfcuserlist',
                                'action' => 'list'
                            )
                        )
                    ),
                ),
            ),
        ),
    ),
);
