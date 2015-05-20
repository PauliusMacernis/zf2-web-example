<?php

namespace Exam\Controller;

use Zend\EventManager\EventManager;
use Exam\Form\Element\Question\QuestionInterface;
use Exam\Model\Test;
use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Zend\Form\Factory;
// listAction
use Zend\Paginator\Adapter\DbSelect as PaginatorDbAdapter;
use Zend\Paginator\Paginator;


class TestController extends AbstractActionController
{

    public function indexAction()
    {
        return array();
    }

    public function listAction()
    {
        $currentPage = $this->params('page', 1);

        $testModel = new Test();
        $result = $testModel->getSql()->select()->where(array('active' => 1));

        $adapter = new PaginatorDbAdapter($result, $testModel->getAdapter());
        $paginator = new Paginator($adapter);

        // @todo: check if paginator cache really works
        $cache = $this->getServiceLocator()->get('text-cache');
        \Zend\Paginator\Paginator::setCache($cache);
        $paginator->setCacheEnabled(true); // just in case the cache was disabled

        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage(10);

        /*
        $currentPage = $this->params('page', 1);
        $cacheKey = 'exam-list-' . $currentPage;

        // Non-core logic to check if we have the data in cache already
        $cache = $this->getServiceLocator()->get('var-cache');
        $paginator = $cache->getItem($cacheKey);

        if(!$paginator) {
            // Core Logic related to listing tests
            $testModel = new Test();
            $result = $testModel->getSql()->select()->where(array('active' => 1));

            $adapter = new PaginatorDbAdapter($result, $testModel->getAdapter());
            $paginator = new Paginator($adapter);

            $paginator->setCurrentPageNumber($currentPage);
            $paginator->setItemCountPerPage(10);

            // Non-Core to save the data in the cache
            $cache->setItem($cache, $paginator->toArray());
        }
        */
        // Caching parts of the code
        //$cache = $this->getServiceLocator()->get('cache');
        //\Zend\Paginator\Paginator::setCache($cache);
        //$paginator->setCacheEnabled(true);      // @todo: make sure this is needed.//just in case the cache was disabled

        return array(
            'tests' => $paginator,
            'page' => $currentPage
        );
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

                $user = $this->getServiceLocator()->get('user');

                $exam = $this->getServiceLocator()->get('test-manager')->get($id);
                $examName = $exam->offsetGet('name');

                $event = new EventManager('exam');
                $event->trigger('taken-excellent', null, array(
                    'user' => $user,
                    'exam' => $examName,
                ));

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

    /**
     * Fills the tests with some default tests
     *
     * @return \Zend\Http\Response
     */
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

        // ..

        $cache = $this->getServiceLocator()->get('text-cache');
        $cache->clearByTags(array('exam-list'));

        // ...

        $this->flashMessenger()->addSuccessMessage('The default test were added');

        return $this->redirect()->toRoute('exam/list');

    }

    public function certificateAction() {

        $pdfService = $this->getServiceLocator()->get('pdf');

        $user = $this->getServiceLocator()->get('user');

        $id = $this->params('id'); // exam id
        if($id) {
            $exam = $this->getServiceLocator()->get('test-manager')->get($id);
            $examName = $exam->offsetGet('name');
        } else {
            $examName = ''; // Exam has no name while no id is provided
        }
        $pdf = $pdfService->generateCertificate($user, $examName);

        $response = $this->getResponse();

        // We need to set a content-type header so that the browser is able to recognize our pdf and display it.
        $response->getHeaders()->addHeaderLine('Content-Type: application/pdf');

        $response->setContent($pdf->render());

        // If we want to shortcut the execution we just return the
        // response object and then the view and the layout are not
        // rendered at all.
        return $response;

    }


}

