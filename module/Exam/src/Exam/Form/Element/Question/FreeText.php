<?php
namespace Exam\Form\Element\Question;


class FreeText extends SingleChoice {

    protected $header = 'Enter the answer in the text field';

    /**
     * @param array|string $answers
     */
    public function setAnswers($answers) {
        parent::setAnswers($answers);
        foreach($this->answers as &$answer) {
            $answer = strtolower($answer);
        }
    }

    /**
     * Provide default input rules for this element
     *
     * Attaches an email validator.
     *
     * @return array
     */
    public function getInputSpecification() {
        return array(
            'name' => $this->getName(),
            'required' => true,
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StringToLower'),
            ),
            'validators' => array(
                $this->getValidator(),
            ),
        );
    }

}