<?php
spl_autoload_register(function ($className) {
    $path = explode('\\', $className);

    /*
        namespace ~ file directory name, that should start rom lower case letter
        so it takes to lower case all first letter of namespaces living unchanged controller name
    */
    for ($i = 0; $i < count($path) - 1; $i++) {
        $path[$i] = lcfirst($path[$i]);
    }

    $file = implode('/', $path);
    $file .= '.php';

    if (file_exists($file)) {
        include $file;
    } else {
        throw new Exception("Unable to load $file");
    }
});