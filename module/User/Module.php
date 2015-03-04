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

    public function protectPage(MvcEvent $e)
    {
        $match = $e->getRouteMatch(); // use RouteMatch object to get the name of the controller, action, and other parameters

        if(!$match) {
            // we cannot do anything without a resolved route
            return;
        }

        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');
        $namespace  = $match->getParam('__NAMESPACE__');
        // ...

    }



}
