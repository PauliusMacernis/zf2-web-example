<?php
namespace Exam\Service\Invokable;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;


class Mail implements ServiceLocatorAwareInterface {

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $services;


    public function sendCertificate($user, $exam, $pdf) {
        $translator = $this->services->get('translator');
        $mail = new Message();
        $mail->addTo($user->getEmail(), $user->getName());

        $text = 'You are genius!
        You answered all the questions correctly.
        Therefore, in appreciation, we are sending you this free award certificate.

        ';

        // we create a new mime message
        $mimeMessage = new MimeMessage();
        // create the original body as part
        $textPart = new MimePart($text);
        $textPart->type = "text/plain";
        // add the pdf document as a second part
        $pdfPart = new MimePart($pdf->render());
        $pdfPart->type = "application/pdf";
        $mimeMessage->setParts(array($textPart, $pdfPart));

        $mail->setBody($mimeMessage);
        $mail->setFrom('exam@veikt.com', 'Exam center of veik.com');
        $mail->setSubject($translator->translate(
           'Congratulations: Here is your award certificate'
        ));

        $transport = $this->getServiceLocator()->get('mail-transport');
        $transport->send($mail);


    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceLocator()
    {
        return $this->services;
    }
}