<?php

namespace Debug\Model;

use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\Adapter;

class Foo implements AdapterAwareInterface {
    /**
     * @var $adapter Adapter 
     */
    protected $adapter;
    
    public function setDbAdapter(Adapter $adapter) {
        $this->adapter = $adapter;
    }

}