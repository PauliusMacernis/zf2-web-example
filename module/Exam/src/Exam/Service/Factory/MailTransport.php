<?php
namespace Exam\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
// For file case
use Zend\Mail\Transport\File as FileTransport;
use Zend\Mail\Transport\FileOptions;
// For sendmail
use Zend\Mail\Transport\Sendmail as SendmailTransport;


class MailTransport implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // For file case
        $transport = new FileTransport();
        $options = new FileOptions(array(
            'path' => 'data/mail/',
            'callback' => function(FileTransport $transport) {
                return 'Message_' . microtime(true) . '_' . mt_rand() . '.eml';
            }
        ));
        $transport->setOptions($options);


        //$transport = new SendmailTransport();

        return $transport;
    }
}