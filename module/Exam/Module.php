<?php
namespace Exam;

use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\Event;

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

    public function onBootstrap(MvcEvent $event) {

        $services = $event->getApplication()->getServiceManager();
        $sharedEventManager = $event->getApplication()->getEventManager()->getSharedManager();

        $sharedEventManager->attach('exam', 'certificate-generated',
            function($event) use ($services) {
                $mail = $services->get('mail');
                $user = $event->getParam('user');
                $exam = $event->getParam('exam');
                $pdf = $event->getParam('pdf');

                $mail->sendCertificate($user, $exam, $pdf);
            }
        );

        $sharedEventManager->attach('exam', 'taken-excellent',
            function(Event $event) use ($services) {

                $user = $event->getParam('user');
                $exam = $event->getParam('exam');

                $pdf = $services->get('pdf');
                $pdfDocument = $pdf->generateCertificate($user, $exam);

                $newEvent = new EventManager('exam');
                $newEvent->trigger('certificate-generated', $this, array(
                   'user' => $user,
                   'exam' => $event->getParam('exam'),
                   'pdf' => $pdfDocument
                ));
        });

    }
}
