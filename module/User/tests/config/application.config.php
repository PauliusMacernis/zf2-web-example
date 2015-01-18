<?php

return array(
    'modules' => array(
        'Application',
        'User',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            // Bellow are the actual configuration files for the application
            'config/autoload/{,*.}{global,local}.php',
            // Here are overides for the test itself
            __DIR__ . '/test/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),
);
