<?php

class Route
{
    static function start()
    {
        // Controller and action by default
        $controller_name = 'index';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Getting the name of controller if it exists
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        // Getting the name of action if it exists
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        // Prefixes addition and taking upper case first letter in controller and model names
        $model_name = ucfirst($controller_name) . 'Model';
        $controller_name = ucfirst($controller_name) . 'Controller';
        $action_name = $action_name . 'Action';

        // Including file with class Model if it exists
        $model_file = $model_name . '.php';
        $model_path = "app/models/" . $model_file;
        if (file_exists($model_path)) {
            include "app/models/" . $model_file;
        }

        // Including file with class Controller
        $controller_file = $controller_name . '.php';
        $controller_path = $_SERVER['DOCUMENT_ROOT']. "/app/controllers/" . $controller_file;

        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            /*
                It's a temporary solution will be fixed in future
                TODO: Exception throwing
            */
            Route::errorPage404();
        }

        // Controller creating
        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            // Calling controller action
            $controller->$action();
        } else {
            /*
                It's a temporary solution will be fixed in future
                TODO: Exception throwing
            */
            Route::errorPage404();
        }
    }

    function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
