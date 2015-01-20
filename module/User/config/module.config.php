<?php
return array(
    'router' => array(
        'routes' => array(
//            'home' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route'    => '/',
//                    'defaults' => array(
//                        'controller' => 'User\Controller\Index',
//                        'action'     => 'index',
//                    ),
//                ),
//            ),
            // Simply drop new controllers in, and you can access them
            // using the path /debug/:controller/:action
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/user',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'me',
                    ),
                ),
                // ...the children definition is comming...
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
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
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'database' => 'User\Service\Factory\Database',
            'entity-manager' => 'User\Service\Factory\EntityManager',
        ),
        'invokables' => array(
            'table-gateway' => 'User\Service\Invokable\TableGateway',
            'user-entity'   => 'User\Model\Entity\User',
        ),
        'shared' => array(
            'user-entity'   => false,
        )
    ),
    'controllers' => array(
        'invokables' => array(
            // bellow is key             and bellow is fully qualified class name
            'User\Controller\Account' => 'User\Controller\AccountController',
            'User\Controller\Log'     => 'User\Controller\LogController',
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
    'table-gateway' => array(
        'map' => array(
            'users' => 'User\Model\User',
        )
    ),
    'doctrine' => array(
        'entity_path' => array(
            __DIR__ . '/../src/User/Model/Entity/',
        ),
        'initializers' => array(
            // add here the list of initializers for Doctrine 2 entities
        ),
    )
    

);
