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
$application = \Core\Application::getInstance();


//  Setting configurations
$application->setConfiguration(
    require "application/config/configuration.php"
); //TODO App::init(require ...)->run(); or can we run application without setting a config? Will it work?

//  Application running
$application->run();