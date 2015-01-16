<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\User as UserForm;
use User\Model\User as UserModel;

//use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController {

    public function indexAction() {
        return array();
    }

    public function addAction() {
        $form = new UserForm();
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(),
                    // Notice: make certain to merge the Files also to the post data
                    $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) {
                // save the data of the new user
                $model = new UserModel();
                $id = $model->insert($form->getData());

                // redirect the user to the view user action
                return $this->redirect()->toRoute('user/default', array(
                            'controller' => 'account',
                            'action' => 'view',
                            'id' => $id
                ));
            }
        }


        // @todo: edit and bring this to model
        // v1
        //// $db = $this->getServiceLocator()->get('database');
        /* $db->query('SELECT id FROM users WHERE username=? AND password=?',
          array($login = 'gfhghh', 'ytut yutyutyu')
          ); */
        // v2
        //// $escapedUsername = $db->getPlatform()->quoteValue($username = 'gfhghh');
        //// $escapedPassword = $db->getPlatform()->quoteValue($password = 'ytut yutyutyu');
        //// $sql = sprintf("SELECT id FROM users WHERE username=%s AND password=%s",
        ////        $escapedUsername, $escapedPassword);
        //// $data = $db->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        // pass the data to the view for visualization
        return array('form1' => $form);
    }

    /**
     * Anonymous users can use this action to register new accounts
     */
    public function registerAction() {
        $result = $this->forward()->dispatch('User\Controller\Account', array('action' => 'add')); // internal redirect

        return $result;
    }

    public function viewAction() {
        return array();
    }

    public function editAction() {
        return array();
    }

    public function deleteAction() {
        // $id = $this->getRequest()->getQuery()->get('id'); // works
        // $id = $this->params()->fromRoute('id'); // also works
        $id = $this->params('id'); // params from request: GET, POST, headers, routing.
        if ($id) {
            $userModel = new UserModel();
            $userModel->delete(array('id' => $id));
        } else {
            // external redirect (new request)
            return $this->redirect()->toRoute('user/default', array(// user/default is name of routes, not part of URL!
                        'controller' => 'account',
                        'action' => 'view'
            ));
        }

        return array();
    }
    
    public function meAction() {
        return array();
    }
    
    public function deniedAction() {
        return array();
    }
    
}
