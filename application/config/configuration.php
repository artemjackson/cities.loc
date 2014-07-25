<?php
return array(
    'MODEL_CONFIGURATION' => array(
        'modelsPath' => 'application/models/',
    ),
    'VIEW_CONFIGURATION' => array(
        'viewsPath' => 'application/views/',
        'layoutsPath' => 'application/views/layouts/',
        'layoutExtension' => '.phtml',
        'defaultLayout' => 'default',
        'templatesPath' => 'application/views/templates/',
        'templatesExtension' => '.phtml',
    ),
    'CONTROLLER_CONFIGURATION' => array(
        'controllersPath' => 'application/controllers/',
        'defaultController' => 'home',
        'defaultAction' => 'index',
    ),
    'DATABASE_CONFIGURATION' => array(
        'databaseType' => 'mysql',
        'databaseName' => 'cities',
        'hostName' => 'localhost',
        'userName' => 'jackson',
        'password' => '9951',
    )
);