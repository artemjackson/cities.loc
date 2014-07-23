<?php
spl_autoload_register(
    function ($className) {
        $path = explode('\\', $className);

        /*
            namespace ~ file directory name, that should start rom lower case letter
            so it takes to lower case all first letter of namespaces living unchanged controller name
        */
        for ($i = 0; $i < count($path) - 1; $i++) {
            $path[$i] = lcfirst($path[$i]);
        }

        $file = implode('/', $path) . '.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new AutoloaderException("Unable to load $file");
        }
    }
);

class AutoloaderException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}