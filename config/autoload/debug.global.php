<?php
return array(
    // The Debug module expects the database service to be called "database".
    // If that is not the case add a service alias that points to the correct name.
        'service_manager' => array(
    // This line is an example how to alias it if the correct name of the service
    // is Zend\Db\Adapter\Profiler\Profiler
            'alias' => array(
                'database-profiler' => 'Zend\Db\Adapter\Profiler\Profiler',
            ),
        )
);