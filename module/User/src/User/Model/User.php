<?php

namespace User\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature;

class User extends AbstractTableGateway
{
    public function __construct(/*$adapter*/)
    {
        $this->table = 'users';
        //$this->adapter = $adapter;
        // If, in most cases, we use the same database adapter object, as is true
        //  at the moment for our User module, then we can improve our User model
        //  by changing the code as follows (using Zend\Db\TableGateway\Feature):
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
    }

    public function insert($set)
    {
        $set['photo'] = $set['photo']['tmp_name'];
        unset($set['password_verify']);
        $set['password'] = md5($set['password']); // better than clear text passwords

        return parent::insert($set);

    }
}
