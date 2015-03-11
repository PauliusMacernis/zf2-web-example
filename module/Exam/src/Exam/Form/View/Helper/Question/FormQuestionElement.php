<?php
namespace Exam\Form\View\Helper\Question;

use Zend\Form\View\Helper\AbstractHelper;
use Exam\Form\Element\Question\QuestionInterface;


class FormQuestionElement extends AbstractHelper {

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param ElementInterface|null $element
     * @return $string|FormInput
     */
    public function __invoke(QuestionInterface $element = null) {
        if(!$element) {
            return $this;
        }

        return $this->render($element);

    }

    /**
     * @param QuestionInterface $element
     * @return string
     */
    public function render(QuestionInterface $element) {

        $view = $this->getView();
        if($element instanceof \Exam\Form\Element\Question\FreeText) {
            $content = $view->formFreeText($element);
        } elseif($element instanceof \Exam\Form\Element\Question\SingleChoice) {
            $content = $view->formSingleChoice($element);
        } else {
            $content = $view->formMultipleChoice($element);
        }

        return $content;

    }

}