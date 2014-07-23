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
$application->setConfiguration(require "application/config/configuration.php");

//  Application running
$application->run();