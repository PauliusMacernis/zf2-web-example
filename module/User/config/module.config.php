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
            'log' => 'User\Service\Factory\Log',
            'password-adapter' => 'User\Service\Factory\PasswordAdapter',
            'auth' => 'User\Service\Factory\Authentication', // todo: make sure this is needed and is used in the right way
            //'auth-adapter' => 'User\Service\Factory\AuthenticationDbAdapter',
            'acl' => 'User\Service\Factory\Acl',
            'user' => 'User\Service\Factory\User',
        ),
        'invokables' => array(
            'table-gateway' => 'User\Service\Invokable\TableGateway',
            'user-entity'   => 'User\Model\Entity\User',
            'user-manager'  => 'User\Model\UserManager',
            //'doctrine-profiler' => 'User\Service\Invokable\DoctrineProfiler', <-- moved to Debug module
            'auth-adapter' => 'User\Authentication\Adapter', // No need to create a separate factory class, ZF2 has it
        ),
        'initializers' => array(
            'password-init' => 'User\Service\Initializer\Password',
            'User\Service\Initializer\Db',
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
            // add here the list of initializers for Doctrine 2 entities...
            'password-init' => 'User\Service\Initializer\Password'
        ),
    ),
    'acl' => array(
        'role' => array(
            // role -> multiple parents
            'guest' => null,
            'member' => null, //array('guest'), <- commented to not extend from guest
            'admin' => null,
        ),
        'resource' => array(
            // resource ->single parent
            'account' => null,
            'log' => null,
        ),
        'allow' => array(
            // array('role', 'resource', array('permission-1', 'permission-2', ...)),
            array('guest', 'log', 'in'),
            array('guest', 'account', 'register'),
            array('member', 'account', array('me')), // the member can only see his account,
            array('member', 'log', 'out'), // the member can log out
            array('admin', null, null), // the admin can do anything with the accounts
        ),
        'deny' => array(
            array('guest', null, 'delete') // null as second parameter means all resources
        ),
        'defaults' => array(
            'guest_role' => 'guest',
            'member_role' => 'member',
        ),
        'resource_aliases' => array(
            'User\Controller\Account' => 'account',
        ),
        // List of modules to apply the ACL
        // This is how we can specify if we have to protect the pages in our current module.
        'modules' => array(
            'User'
        )
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'User',
                'route' => 'user/default',
                'controller' => 'account',
                'pages' => array(
                    array(
                        'label' => 'Me',
                        // uri
                        'route' => 'user/default',
                        'controller' => 'account',
                        'action' => 'me',
                        // acl
                        'resource' => 'account',
                        'privilege' => 'me',
                    ),
                    array(
                        'label' => 'Log in',
                        // uri
                        'route' => 'user/default',
                        'controller' => 'log',
                        'action' => 'in',
                        // acl
                        'resource' => 'log',
                        'privilege' => 'in',
                    ),
                    array(
                        'label' => 'Register',
                        // uri
                        'route' => 'user/default',
                        'controller' => 'account',
                        'action' => 'register',
                        // acl
                        'resource' => 'account',
                        'privilege' => 'register',

                    ),
                    array(
                        'label' => 'Log out',
                        // uri
                        'route' => 'user/default',
                        'controller' => 'log',
                        'action' => 'out',
                        // acl
                        'resource' => 'log',
                        'privilege' => 'out',
                    )
                )
            )
        ),
    ),
    

);
