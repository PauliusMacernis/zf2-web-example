<?php
return array(
    'view_helpers' => array(
        'invokables' => array(
            'formMultipleChoice' => 'Exam\Form\View\Helper\Question\FormMultipleChoice',
            'formSingleChoice' => 'Exam\Form\View\Helper\Question\FormSingleChoice',
            'formFreeText' => 'Exam\Form\View\Helper\Question\FormFreeText',
            'formQuestionElement' => 'Exam\Form\View\Helper\Question\FormQuestionElement',
        )
    ),
    'router' => array(
        'routes' => array(
            'exam' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/exam',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Exam\Controller',
                        'controller' => 'Test', // @TODO: 'Index' ?
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]*',
                            ),
                            'defaults' => array(

                            ),
                        ),
                    ),
                    'list' => array(
                        /*
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/test/list',
                            'defaults' => array(
                                'controller' => 'Test',
                                'action' => 'list',
                            ),
                        )
                        */
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/test/list[/:page]',
                            'constraints' => array(
                                'page'         => '[0-9]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'test',
                                'action'        => 'list',
                                'page'          => 1,
                                //'pagecache'     => isset($_COOKIE['LANG']) ? $_COOKIE['LANG'] : 'en',
                                'actioncache'   => 1,
                                'tags'          => array('exam-list'),
                            ),
                        ),
                    )
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            // bellow is key             and bellow is fully qualified class name
            'Exam\Controller\Test' => 'Exam\Controller\TestController',
        ),
    ),
    'view_manager' => array(
//      'display_not_found_reason' => true,
//      'display_exceptions'       => true,
//      'doctype'                  => 'HTML5',
//      'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            // paginator views
            'paginator/sliding'       => __DIR__ . '/../view/paginator/sliding.phtml',
//          'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//          'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
//          'error/404'               => __DIR__ . '/../view/error/404.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'test-manager' => 'Exam\Model\TestManager',
        )
    ),
    'acl' => array(
        'resource' => array(
            'test' => null,
        ),
        'allow' => array(
            array('guest', 'test', 'list'),
            array('member', 'test', array('list', 'take')),
            array('admin', 'test', array('reset')),
        ),
        'modules' => array(
            'Exam',
        )
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Exam',
                'route' => 'exam',
                'pages' => array(
                    array(
                        'label' => 'List',
                        'route' => 'exam/list',
                        // acl
                        'resource' => 'test',
                        'privilege' => 'list',
                    ),
                    array(
                        'label' => 'Reset',
                        'title' => 'Reset the test to the default set',
                        // uri
                        'route' => 'exam/default',
                        'controller' => 'test',
                        'action' => 'reset',
                        // acl
                        'resource' => 'test',
                        'privilege' => 'reset',
                    ),
                )
            ),
        )
    ),
);