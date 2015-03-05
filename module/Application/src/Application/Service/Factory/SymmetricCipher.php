<?php
/**
 * Created by PhpStorm.
 * User: Paulius
 * Date: 2015-03-05
 * Time: 23:38
 */

namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\BlockCipher;

class SymmetricCipher implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $blockCipher = BlockCipher::factory(
            $config['cipher']['adapter'],
            $config['cipher']['options']
        );
        $blockCipher->setKey($config['cipher']['encryption_key']);

        return $blockCipher;

    }

}