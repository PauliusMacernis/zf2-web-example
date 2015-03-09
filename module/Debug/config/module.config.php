<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Debug\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // Simply drop new controllers in, and you can access them
            // using the path /debug/:controller/:action
            'debug' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/debug',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Debug\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            //'timer' => 'Debug\Service\Factory\Timer'
        ),
        'abstract_factories' => array(
            'Debug\Service\Factory\TimerAbstractFactory'
        ),
        'invokables' => array(
            //'timer' => 'Debug\Service\Timer'
            'doctrine-profiler' => 'Debug\Service\Invokable\DoctrineProfiler', //<-- moved from User module
        ),
        'aliases' => array(
            'Debug\Timer' => 'timer',
        ),
        'initializers' => array(
            'Debug\Service\Initializer\DbProfiler',
        )

    ),
//    'translator' => array(
//        'locale' => 'en_US',
//        'translation_file_patterns' => array(
//            array(
//                'type'     => 'gettext',
//                'base_dir' => __DIR__ . '/../language',
//                'pattern'  => '%s.mo',
//            ),
//        ),
//    ),
    'controllers' => array(
        'invokables' => array(
            'Debug\Controller\Index' => 'Debug\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions'       => true,
//        'doctype'                  => 'HTML5',
//        'not_found_template'       => 'error/404',
//        'exception_template'       => 'error/index',
//        'template_map' => array(
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
//            'error/404'               => __DIR__ . '/../view/error/404.phtml',
//            'error/index'             => __DIR__ . '/../view/error/index.phtml',
//        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
//    'console' => array(
//        'router' => array(
//            'routes' => array(
//            ),
//        ),
//    ),
//    'application' => array(
//        'version'   => '[0.0.1]',
//        'name'      => '[Application name]'
//    )
    'timers' => array( // This is top-level config key for our abstract factory
        'timer' => array( // This is the name of our service
            'times_as_float' => true,
            // and in the array we have parameters to use for the service
        ),
        'timer_non_float' => array( // This is the name of our service
            'times_as_float' => false,
        )
    ),
);
