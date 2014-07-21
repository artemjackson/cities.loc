<?php
namespace Core;

class Route
{
    public static function start()
    {
        // Controller and action by default
        $controllerName = 'index';
        $actionName = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Getting the name of controller if it exists
        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        // Getting the name of action if it exists
        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        // Prefixes addition and taking upper case first letter in controller name
        $controllerName = 'Application\\Controllers\\' . ucfirst($controllerName) . 'Controller';
        $actionName = $actionName . 'Action';

        if (!class_exists($controllerName)) {
            die ($controllerName);

            Route::errorPage404();
        }

        //creating controller
        $controller = new $controllerName;

        if (!method_exists($controller, $actionName)) {
            /*
            It's a temporary solution will be fixed in future
            TODO: Exception throwing
            */
            Route::errorPage404();
        }

        // Calling controller action
        $controller->$actionName();
    }

    function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
