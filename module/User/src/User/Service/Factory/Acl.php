<?php
namespace User\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Permissions\Acl\Acl as AccessControlList;


class Acl implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $aclConfig = $config['acl'];

        $acl = new AccessControlList();

        // add the defined resources
        foreach($aclConfig['resource'] as $resource => $parent) {
            $acl->addResource($resource, $parent);
        }

        // add the defined roles
        foreach($aclConfig['role'] as $role => $parents) {
            $acl->addRole($role, $parents);
        }

        // add the allow and deny definitions
        foreach(array('allow', 'deny') as $action) {
            foreach($aclConfig[$action] as $definition) {
                call_user_func_array(array($acl, $action), $definition);
            }
        }

        return $acl;

        /*
        // OLDIES...
        // Bellow is how we declare the account resource
        $account = $acl->addResource('account');

        $log = $acl->addResource('log');

        // Bellow is how we declare the guest role
        $guest = $acl->addRole('guest');
        // .. and his permissions -
        $acl->allow($guest, $account, array('register'));
        $acl->allow($guest, $log, array('in'));

        // This is how we declare the member role
        // Notice that the member inherits the rights from the guest
        // meaning that he, like the guest, can also log in
        $member = $acl->addRole('member', $guest);
        // .. and in addition he can view his own account
        $acl->allow($member, $account, array('edit'));
        $acl->allow($member, $log, array('out'));

        // Here we define the admin
        $admin = $acl->addRole('admin');
        // who can do everything with the resources in the system
        // the missing second and third parameters allow us to do this
        $acl->allow($admin);

        return $acl;
        //END. OLDIES...
        */

    }

}