<?php
/*
 * Enabling errors
 */
ini_set('display_errors', 1);

/*
 *   Everything is relative
 *   to the application root now.
 */
chdir(dirname(__DIR__));

require_once 'init_autoloader.php';


// Application is realized by singleton pattern
$app = \Core\App::getInstance();

//  Setting default configurations
$app->setConfig(
    require "app/config/config.php"
); //TODO App::init(require ...)->run(); or can we run application without setting a config? Will it work?

//  Setting local database configuration
$app->setConfig(require "app/config/dbConfig.local.php"); // TODO you should merge all config files from config folder into one array

//  Application running
$app->run();