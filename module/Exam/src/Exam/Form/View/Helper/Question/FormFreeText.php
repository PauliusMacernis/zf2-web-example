<?php
namespace Exam\Form\View\Helper\Question;

use Zend\Form\View\Helper\FormText;
//use Exam\Form\Element\Question\FreeText;
use Zend\Form\ElementInterface;

class FormFreeText extends FormText {

    /**
     * Render
     *
     * @param FreeText $element
     * @return string
     */
    public function render(ElementInterface $element) {
        $question = $element->getQuestion();
        $header = $element->getHeader();

        $content = "<dd><pre>"
            . $this->getView()->escapeHtml($question)
            . "</pre></dd>";
        $content .= "<dl>$header</dl>";
        $content .= parent::render($element);

        return $content;

    }

}