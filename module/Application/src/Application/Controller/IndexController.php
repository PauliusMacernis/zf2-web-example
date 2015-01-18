<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');

        // layout will be our parent model
        $layoutViewModel = new ViewModel();
        // it must render view template with name 'layout/layout'
        $layoutViewModel->setTemplate('layout/layout');


        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'version' => $config['application']['version'],
            'applicationName' => $config['application']['name']
        ));
        $viewModel->setTemplate('application/index/index');

        return $viewModel;

    }

    public function aboutAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariables(array());
        $viewModel->setTemplate('application/index/about');

        $viewModel->setTerminal(true); // prevent adding children

        return $viewModel;

    }
}
