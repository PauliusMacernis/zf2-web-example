<?php
namespace User\Service\Factory;

use Zend\Authentication\Adapter\DbTable as DbAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationDbAdapter.
 * Good thing about having authentication adapter separate from authentication service itself is that we will be able to
 * easily switch between authentication adapters if there will be such need in the future. For example, implementing
 * LDAP server adapter would be quite easy - just extend the current adapter or use the completely new one.
 *
 * Furthermore, any changes in authentication should not be in the current module. We could create an Ldap module that
 * overwrites the auth-adapter service. If we want to create a custom authentication adapter, the only change would be
 * to point the 'auth-adapter' key to the new custom authentication adapter.
 *
 * @package User\Service\Factory
 */
class AuthenticationDbAdapter implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db = $serviceLocator->get('database');

        $adapter = new DbAdapter(
            $db,                // An instance of Zend\Db\Adapter\Adapter
            'users',            // The name of the table where the username and the password are stored
            'login',            // The name of the table column responsible for the username
            'password',         // The name of the table field responsible for the password
            'MD5(password)'     // Responsible for password treatment
        );

        return $adapter;

    }

}