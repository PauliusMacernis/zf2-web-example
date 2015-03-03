<?php

namespace User\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

// ...

class UserManager implements ServiceLocatorAwareInterface {
    
    /**
     * @var ServiceLocatorInterface
     */
    protected $services;
    
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator() {
        return $this->services;
    }

    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->services = $serviceLocator;
    }
    
    /**
     * Creates and fills the user entity identified by user identity.
     * @param string $identity
     * @return Entity\User
     */
    public function create($identity) {
        $user = $this->services->get('user-entity');
        $entityManager = $this->services->get('entity-manager');
        
        //$user = $entityManager->getRepository(get_class($user))
        //        ->findOneById($id);
        
        //$user = $entityManager->getRepository(get_class($user))
        //        ->find($id);
        
        //$user = $entityManager->getRepository(get_class($user))
        //        ->findByRole('admin');
        
        //$query = $entityManager->createQuery("SELECT COUNT(u.id) FROM " . get_class($user) . " WHERE u.role = 'admin' AND u.email LIKE '%@gmail.com'");
        //$count = $query->getSingleScalarResult();
        
        $user = $entityManager->getRepository(get_class($user))
                ->findOneByEmail($identity);
        
        return $user;
        
    }
    
    /**
     * Creates and fills the user entity identified by user id.
     * @param string $identity
     * @return Entity\User
     */
    public function createById($identity) {
        $user = $this->services->get('user-entity');
        $entityManager = $this->services->get('entity-manager');
        
        return $entityManager->getRepository(get_class($user))
                ->findOneById($identity);
        
        
    }
    

}