<?php
namespace User\Service\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Model\PasswordAwareInterface;


class Password implements InitializerInterface {
    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if($instance instanceof PasswordAwareInterface) {
            $instance->setPasswordAdapter($serviceLocator->get('password-adapter'));
        }
    }

}