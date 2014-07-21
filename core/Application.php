<?php
namespace Core;

use Core\Route;

class Application
{
    public static function run()
    {
        Route::start();
    }
}