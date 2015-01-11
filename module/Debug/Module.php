<?php

namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

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
        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, 'addDebugOverlay'), 100);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));

        // Bellow is how we get access to the service manager
        $serviceManager = $e->getApplication()->getServiceManager();

        // Here we start the timer 
        $timer = $serviceManager->get('timer');
        $timer->start('mvc-execution');
        // And here we attach a listener to the finish event that has to be executed with priority 2
        // The priority here is 2 because listeners with that priority will be executed just before the
        // actual finish event is triggered.
        $eventManager->attach(MvcEvent::EVENT_FINISH, array($this, 'getMvcDuration'), 2);
    }

    public function addDebugOverlay(MvcEvent $event) {
        $viewModel = $event->getViewModel();

        // if this is not terminated case (e.g. Ajax query)
        if (!$viewModel->terminate()) {

            $sidebarView = new ViewModel();
            $sidebarView->setTemplate('debug/layout/sidebar');
            $sidebarView->addChild($viewModel, 'content');
            $event->setViewModel($sidebarView);
        }
    }

    public function handleError(MvcEvent $event) {
        $controller = $event->getController();
        $error = $event->getParam('error');
        $exception = $event->getParam('exception');
        $message = 'Error: ' . $error;
        if ($exception instanceof \Exception) {
            $message .= ', Exception(' . $exception->getMessage() . '): ' .
                    $exception->getTraceAsString();
        }

        error_log($message);
    }

    public function getMvcDuration(MvcEvent $event) {

        // Here we get service manager
        $serviceManager = $event->getApplication()->getServiceManager();
        // Get the already created instance of our timer service
        $timer = $serviceManager->get('timer');
        $duration = $timer->stop('mvc-execution');
        // and finally print the duration
        error_log("MVC Duration:" . $duration . " seconds");

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
