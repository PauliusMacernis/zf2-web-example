<?php
namespace User\Authentication;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Adapter extends AbstractAdapter implements ServiceLocatorAwareInterface {

    /**
     * @var ServiceLocator;
     */
    protected $serviceLocator;

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $entityManager = $this->serviceLocator->get('entity-manager');
        $userEntityClassName = get_class($this->serviceLocator->get('user-entity'));
        // We ask the Doctrine 2 entity manager to find a user
        // with the specified email
        $user = $entityManager->getRepository($userEntityClassName)->findOneByEmail($this->identity);

        // And if we have such user we check if his password is matching
        if($user && $user->verifyPassword($this->credential)) {
            // upon successful validation we can
            // return the user entity object
            return new Result(Result::SUCCESS, $user);
        }

        return new Result(Result::FAILURE, $this->identity);

    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}