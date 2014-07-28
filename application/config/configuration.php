<?php
return array(
    'model' => array(
        'modelsPath' => 'application/models/',
    ),

    'view' => array(
        'viewsPath' => 'application/views/',
        'layoutsPath' => 'application/views/layouts/',
        'layoutsExtension' => '.phtml',
        'defaultLayout' => 'default',
        'templatesPath' => 'application/views/templates/',
        'templatesExtension' => '.phtml',
    ),

    'controller' => array(
        'controllersPath' => 'application/controllers/',
        'defaultController' => 'home',
        'defaultAction' => 'index',
    ),

    'database' => array(
        'databaseType' => 'mysql',
        'databaseName' => 'cities',
        'host' => 'localhost',
        'user' => 'jackson',
        'password' => '9951',
    )
);