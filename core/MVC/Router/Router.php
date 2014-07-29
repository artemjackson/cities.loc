<?php

namespace Core\MVC\Router;

use Core\Application;
use Core\MVC\Router\Exceptions\ControllerException;


/**
 * Class Router
 * @package Core\MVC\Router
 */
class Router
{
    //TODO why do name it $currentController but not just simple $controller
    /**
     * @var
     */
    protected $currentController;

    //TODO the same as $currentController
    /**
     * @var
     */
    protected $currentControllerAction;

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->currentController;
    }

    /**
     * @return mixed
     */
    public function getControllerAction()
    {
        return $this->currentControllerAction;
    }

    /**
     * @throws Exceptions\ControllerException
     */
    public function run()
    {
        $defaultController = Application::getConfiguration('controller', 'defaultController');
        $defaultAction = Application::getConfiguration('controller', 'defaultAction');
        $controllersPath = Application::getConfiguration('controller', 'controllersPath');

        // Controller and action by default
        $controllerName = $defaultController;
        $actionName = $defaultAction;

        // Separating request URI
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Getting the name of controller if it exists
        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        // Getting the name of action if it exists
        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        //  Recreating path to controllers into namespaces
        $namespaces = explode('/', $controllersPath);

        // Namespaces should start from capital letter
        for ($i = 0, $size = count($namespaces); $i < $size; $i++) {
            $namespaces[$i] = ucfirst($namespaces[$i]);
        }

        $prefix = implode('\\', $namespaces);

        // Prefixes addition and taking upper case first letter in controller name
        $controllerName = $prefix . ucfirst($controllerName) . 'Controller';
        $actionName = $actionName . 'Action';

        //creating controller
        try {
            $this->currentController = new $controllerName;

            if (!method_exists($controllerName, $actionName)) {
                throw new  ControllerException(
                    "Undefined controller action: {$actionName} of {$controllerName}."
                );
            }
            $this->currentControllerAction = $actionName;
        } catch (\AutoloaderException $e) {
            throw new  ControllerException("Undefined controller: {$controllerName}.", 404, $e);
        }
    }
}