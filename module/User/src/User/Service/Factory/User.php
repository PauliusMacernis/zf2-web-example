<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class User implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $auth = $serviceLocator->get('auth');

        if($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            if(!$user->getRole()) {
                $user->setRole($config['acl']['defaults']['member_role']);
            }
        } else {
            $user = $serviceLocator->get('user_entity');
            $user->setId(null);
            $user->setRole($config['acl']['defaults']['guest_role']);
        }

         return $user;

    }

}