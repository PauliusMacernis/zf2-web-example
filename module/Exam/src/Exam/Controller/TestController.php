<?php

namespace Exam\Controller;

use Exam\Form\Element\Question\QuestionInterface;
use Exam\Model\Test;
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

    public function takeAction()
    {
        $id = $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('exam/list');
        }

        /* Two comment following lines were added instead of these three commented:
        $factory = new Factory();
        $spec = include __DIR__ . '/../../../config/form/form1.php';
        $form = $factory->create($spec);
        */
        $testManager = $this->serviceLocator->get('test-manager');
        $form = $testManager->createForm($id);

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

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);
            $correct = 0;
            $total = 0;
            if ($form->isValid()) {
                $this->flashMessenger()->addSuccessMessage('Great! You have 100% correct answers.');
            } else {
                // Mark count the number of correct answers
                foreach ($form as $element) {
                    if ($element instanceof QuestionInterface) {
                        $total++;
                        $form->setValidationGroup($element->getName());
                        $form->setData($data);
                        if ($form->isValid()) {
                            $correct++;
                        }
                    }
                }
                $percents = $correct * 100 / $total;
                $message = sprintf('You are %d%s correct.', $percents, '%');
                $this->flashMessenger()->addInfoMessage($message);
            }
        }

        return array('form' => $form);

    }

    public function resetAction() {

        $model = new Test();

        // Delete all existing tests
        if($this->params('flush')) {
            $model->delete(array());
        }

        // fill the default tests
        $manager = $this->serviceLocator->get('test-manager');
        $tests = $manager->getDefaultTests();
        foreach($tests as $test) {
            $data = $test['info'];
            $data['definition'] = json_encode($test);
            $manager->store($data);
        }

        $this->flashMessenger()->addSuccessMessage('The default test were added');

        return $this->redirect()->toRoute('exam/list');

    }


}

