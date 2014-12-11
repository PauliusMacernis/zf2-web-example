<?php

namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface {

    public function init(ModuleManager $moduleManager) {

        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach('loadModules.post', array($this, 'loadedModulesInfo'));
    }

    public function loadedModulesInfo(Event $event) {

        $moduleManager = $event->getTarget();
        $loadedModules = $moduleManager->getLoadedModules();
        error_log(var_export($loadedModules, true));
    }

    public function onBootstrap(MvcEvent $e) {

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
    }

    public function handleError(MvcEvent $event) {

        $controller = $event->getController();
        $error      = $event->getParam('error');
        $exception  = $event->getParam('exception');
        $message    = 'Error: ' . $error;
        if ($exception instanceof \Exception) {
            $message .= ', Exception(' . $exception->getMessage() . '): ' .
                    $exception->getTraceAsString();
        }

        error_log($message);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
