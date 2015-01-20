<?php

namespace User\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

// ...

class UserManager implements ServiceLocatorAwareInterface {
    
    
    public function getServiceLocator() {
        
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        
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

}