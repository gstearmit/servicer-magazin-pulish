<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'fileupload'         => 'FileUpload\Controller\Index',
            'fileupload_prg'      => 'FileUpload\Controller\Prg',
            'fileupload_progress' => 'FileUpload\Controller\Progress',
        ),
    ),
    'router' => array(
        'routes' => array(
            'fileupload' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/file-upload',
                    'defaults' => array(
                        'controller'    => 'fileupload',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'success' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/success',
                            'defaults' => array(
                                'controller'    => 'fileupload',
                                'action'        => 'success',
                            ),
                        ),
                    ),

                    'single' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/single',
                            'defaults' => array(
                                'controller'    => 'fileupload',
                                'action'        => 'single',
                            ),
                        ),
                    ),

                    'multi-html5' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/multi-html5',
                            'defaults' => array(
                                'controller'    => 'fileupload',
                                'action'        => 'multi-html5',
                            ),
                        ),
                    ),

                    'collection' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/collection',
                            'defaults' => array(
                                'controller'    => 'fileupload',
                                'action'        => 'collection',
                            ),
                        ),
                    ),

                    'partial' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/partial',
                            'defaults' => array(
                                'controller'    => 'fileupload',
                                'action'        => 'partial',
                            ),
                        ),
                    ),

                    //
                    // PRG PLUGIN EXAMPLES
                    //
                    'prg' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/prg',
                        ),
                        'child_routes' => array(
                            'multi-html5' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/multi-html5',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_prg',
                                        'action'        => 'multi-html5',
                                    ),
                                ),
                            ),
                            'fieldset' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/fieldset',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_prg',
                                        'action'        => 'fieldset',
                                    ),
                                ),
                            ),
                        ),
                    ),

                    //
                    // PRG PLUGIN EXAMPLES
                    //
                    'progress' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/progress',
                        ),
                        'child_routes' => array(
                            'session' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/session',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_progress',
                                        'action'        => 'session',
                                    ),
                                ),
                            ),
                            'session_partial' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/session-partial',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_progress',
                                        'action'        => 'session-partial',
                                    ),
                                ),
                            ),
                            'session-progress' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/session-progress',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_progress',
                                        'action'        => 'session-progress',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'file-upload' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
