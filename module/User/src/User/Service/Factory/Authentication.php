<?php
namespace User\Service\Factory;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class Authentication implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // The adapter is what represents the connection to that system.
        $adapter = $serviceLocator->get('auth-adapter');

        $auth = new AuthenticationService();
        $auth->setAdapter($adapter);

        return $auth;
    }

}