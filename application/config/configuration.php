<?php
//TODO rename to config.php
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
    //TODO move this config to local file which is not in GIT. something like local.php or db.local.php. All *.local.php or local.php files must be ignored by GIT
    'database' => array(
        'databaseType' => 'mysql',
        'databaseName' => 'cities',
        'host' => 'localhost',
        'user' => 'jackson',
        'password' => '9951',
    )
);