<?php

namespace User\Service\Initializer;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Db implements InitializerInterface
{
    /**
     * initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if($instance instanceof AdapterAwareInterface) {
            $instance->setDbAdapter($serviceLocator->get('database'));
        }
    }
}
