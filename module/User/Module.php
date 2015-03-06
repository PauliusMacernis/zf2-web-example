<?php
namespace User;

use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        // existing code...

        $services = $e->getApplication()->getServiceManager();
        $dbAdapter = $services->get('database');
        // Set the default database adapter
        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($dbAdapter);

        // Protect module requests
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'protectPage'), -100);

        $sharedEventManager = $eventManager->getSharedManager();

        // Attach logger to log-fail of user
        $sharedEventManager->attach('user', 'log-fail', function($event) use ($services) {
            $username = $event->getParam('username');
            $log = $services->get('log');
            // This is shorthand form of this:
            // $log->log(Zend\Log\Logger::WARN, 'Error logging user [' . $username . ']')
            $log->warn('Error logging user [' . $username . ']');
        });

        // Attach logger to register of user
        $sharedEventManager->attach('user', 'register', function($event) use ($services) {
            $user = $event->getParam('user');
            $log = $services->get('log');
            // This is shorthand form of this:
            // $log->log(Zend\Log\Logger::WARN, 'Error logging user [' . $username . ']')
            $log->warn('Registered user [' . $user->getName() . '/' . $user->getId() . ']');
        });

    }

    public function protectPage(MvcEvent $event)
    {
        $match = $event->getRouteMatch(); // use RouteMatch object to get the name of the controller
            //, action, and other parameters

        if(!$match) {
            // we cannot do anything without a resolved route
            return;
        }

        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');
        $namespace  = $match->getParam('__NAMESPACE__');

        // Limit the execution of redirect to the current module only
        if(strpos($namespace, __NAMESPACE__) !== 0) {
            return;
        } elseif( // Also, let such user to login or add (aka. register)
            strpos($namespace, __NAMESPACE__) === 0
            && in_array($controller, array('User\Controller\Account'))
            && in_array($action,     array('register', 'add'))
        ) {
            return;
        }

        $services = $event->getApplication()->getServiceManager();

        $auth = $services->get('auth');
        if(!$auth->hasIdentity()) {
            // Set the response code to HTTP 401: Auth Required
            $response = $event->getResponse();
            $response->setStatusCode(401);
            $match->setParam('controller', 'User\Controller\Log');
            $match->setParam('action', 'in');
        }

    }



}
