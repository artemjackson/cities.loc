<?php

return array(
    'model' => array(
        'modelsPath' => 'app/models/',
    ),
    'view' => array(
        'viewsPath' => 'app/views/',
        'layoutsPath' => 'app/views/layouts/',
        'layoutsExtension' => '.phtml',
        'defaultLayout' => 'default',
        'templatesPath' => 'app/views/templates/',
        'templatesExtension' => '.phtml',
    ),
    'controller' => array(
        'controllersPath' => 'app/controllers/',
        'defaultController' => 'home',
        'defaultAction' => 'index',
    ),
    /**
     *  FOR DB CONNECTION USE CONFIG SUCH THIS ONE
     *
     *  'db' => array(
     *       'dbType' => 'mysql',
     *       'dbName' => 'cities',
     *       'host' => 'localhost',
     *       'user' => 'jackson',
     *       'password' => '9951',
     *   )
     *
     */
);