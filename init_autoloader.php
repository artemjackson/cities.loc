<?php
spl_autoload_register(
/**
 * @param $className
 * @throws AutoloaderException
 */
    function ($className) {
        /*
         * Core classes should start from upper case first letter
         * User classes should start from lower case first letter
         */

        $path = explode('\\', $className);

        $path[0] = lcfirst($path[0]);
        if ($path[0] !== 'core') {
            /*
            *  namespace ~ file directory name, that should start rom lower case letter
            *  so it takes to lower case all first letter of namespaces living unchanged controller name
            */
            for ($i = 1, $size = count($path) - 1; $i < $size; $i++) {
                $path[$i] = lcfirst($path[$i]);
            }
        }
        $file = implode('/', $path) . '.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new AutoloaderException("Unable to load $file");
        }
    }
);

/**
 * Class AutoloaderException
 */
class AutoloaderException extends Exception
{
}