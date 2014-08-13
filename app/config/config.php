<?php
$dir = __DIR__ . DIRECTORY_SEPARATOR . "autoload";
$dh = opendir($dir);

$config = array();

while ($filename = readdir($dh)) {

    if ($filename !== '.' && $filename !== '..') {
        $filename = $dir . DIRECTORY_SEPARATOR . $filename;
        $addition = include_once($filename);
        if (is_array($addition)) {
            $config = array_merge($config, $addition);
        }
    }
}

return $config;
