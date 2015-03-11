<?php

namespace Exam\Controller;

use Exam\Form\Element\Question\QuestionInterface;
use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Zend\Form\Factory;

class TestController extends AbstractActionController
{

    public function indexAction()
    {
        return array();
    }

    public function listAction()
    {
        return array();
    }

    public function takeAction() {
        $id = $this->params('id');
        if(!$id) {
            return $this->redirect()->toRoute('exam/list');
        }

        $factory = new Factory();
        $spec = include __DIR__ . '/../../../config/form/form1.php';
        $form = $factory->create($spec);

        $form->setAttribute('method', 'POST');

        $form->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security',
        ));

        $form->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Ready',
            )
        ));

        if($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);
            $correct = 0;
            $total = 0;
            if($form->isValid()) {
                $this->flashMessenger()->addSuccessMessage('Great! You have 100% correct answers.');
            } else {
                // Mark count the number of correct answers
                foreach($form as $element) {
                    if($element instanceof QuestionInterface) {
                        $total++;
                        $form->setValidationGroup($element->getName());
                        $form->setData($data);
                        if($form->isValid()) {
                            $correct++;
                        }
                    }
                }
                $percents = $correct * 100 / $total;
                $this->flashMessenger()->addInfoMessage(sprintf('You are %s% correct.', $percents));
            }
        }

        return array('form' => $form);

    }


}

