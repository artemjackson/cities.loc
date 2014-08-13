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

/*
 *  Running application with configuration
 */
\Core\App::init(require "app/config/config.php")->run();