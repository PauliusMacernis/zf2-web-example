<?php
/**
 * Created by PhpStorm.
 * User: Paulius
 * Date: 2015-05-08
 * Time: 01:34
 */

namespace Exam\Service\Invokable;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendPdf\PdfDocument;
use ZendPdf\Page;
use ZendPdf\Font;

//use ZendPdf as Pdf;
use ZendPdfTest\ExtendedZendPDFPage;

class Pdf implements ServiceLocatorAwareInterface {

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $services;

    /**
     * Generates award certificate and
     * triggers an event when the file is generated
     * @param \User\Model\Entity\User   $user
     * @param string                    $examName
     */
    public function generateCertificate($user, $examName) {
        $config = $this->services->get('config');

        //$pdf = new PdfDocument();
        //$pdf->pages[] = ($page = $pdf->newPage(Page::SIZE_A4));

        $pdf = PdfDocument::load($config['pdf']['exam_certificate']);

        // Get the first page
        $page = $pdf->pages[0];

        // Extract pdf fonts used in the document
        /*
        $fontList = $pdf->extractFonts();
        $yPosition = 600;
        foreach($fontList as $font) {
            $page->setFont($font, 15);
            $fontName = $font->getFontName(Font::NAME_POSTSCRIPT, 'en', 'UTF-8');

            $page->drawText($fontName . ': The quick brown fox jumps over the lazy dog', 100, $yPosition, 'UTF-8');
            $yPosition -= 30;
        }

        return $pdf;
        */

        // Extract the AdineKirnberg-Script font included in the PDF sample
        $font = $page->extractFont("AdineKirnberg-Script");
        $page->setFont($font, 80);

        // and write the name of user with it

        //var_dump($user);
        $page->drawText($user->getName(), 200, 280);

        // after that use Time Bold to write the name of the exam
        $font = Font::fontWithName(Font::FONT_TIMES_BOLD);
        $page->setFont($font, 40);
        $page->drawText($examName, 200, 120);

        // We use png image from the public/images folder
        $imageFile = 'public/img/zf2-logo.png';
        // get the right size to do some calculations
        $size = getimagesize($imageFile);
        // load the image
        $image = \ZendPdf\Image::imageWithPath($imageFile);
        $x = 580;
        $y = 440;
        // and finally draw the image
        $page->drawImage($image, $x, $y, $x+$size[0], $y+$size[1]);




        return $pdf;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->services;
    }

}