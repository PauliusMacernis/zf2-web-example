<?php

namespace Debug\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Debug\Service\Timer as TimerService;

class TimerAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Configuration key holding timer configuration
     *
     * @var string
     */
    protected $configKey = 'timers';

    /**
     * Check if can create a service for requested name
     *
     * @param ServiceLocatorInterface $services
     * @param string $name
     * @param string $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        $config = $services->get('config');
        if(empty($config)) {
            return false;
        }

        return isset($config[$this->configKey][$requestedName]);

    }

    /**
     * Create a service for requested name
     *
     * @param ServiceLocatorInterface $services ServiceManager
     * @param string $name
     * @param string $requestedName
     * @return TimerService
     */
    public function createServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        $config = $services->get('config');
        $timer = new TimerService($config[$this->configKey][$requestedName]['times_as_float']);

        return $timer;

    }

}
