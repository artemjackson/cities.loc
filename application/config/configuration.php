<?php
return array(
    'MODEL_CONFIGURATION' => array(
        'MODELS_PATH' => 'application/models/',
    ),

    'VIEW_CONFIGURATION' => array(
        'VIEWS_PATH' => 'application/views/',
        'LAYOUTS_PATH' => 'application/views/layouts/',
        'DEFAULT_LAYOUT' => 'default',
        'LAYOUT_EXTENSION' => '.phtml',
        'TEMPLATES_PATH' => 'application/views/templates/',
        'TEMPLATES_EXTENSION' => '.phtml',
    ),

    'CONTROLLER_CONFIGURATION' => array(
        'CONTROLLERS_PATH' => 'application/controllers/',
        'DEFAULT_CONTROLLER' => 'home',
        'DEFAULT_ACTION' => 'index',
    ),

    'DATABASE_CONFIGURATION' => array(
        'DATABASE_TYPE' => 'mysql',
        'HOST' => 'localhost',
        'USER' => 'jackson',
        'PASSWORD' => '9951',
    )
);