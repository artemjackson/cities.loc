<?php

namespace Core;

class Router
{
    public function __construct($configuration)
    {
        if (!$configuration) {
            throw new Exceptions\NoSuchControllerException("No configuration were specified.");
        }
        $this->controllersPath = $configuration['controllersPath'];
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getControllerAction()
    {
        return $this->controllerAction;
    }

    public function run()
    {
        // Controller and action by default
        $controllerName = 'home';
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

        //  Recreating path to controllers into namespaces
        $namespaces = explode('/', $this->controllersPath);

        // Namespaces should start from capital letter
        for ($i = 0; $i < count($namespaces); $i++) {
            $namespaces[$i] = ucfirst($namespaces[$i]);
        }

        $prefix = implode('\\', $namespaces);

        // Prefixes addition and taking upper case first letter in controller name
        $controllerName = $prefix . ucfirst($controllerName) . 'Controller';
        $actionName = $actionName . 'Action';

        //creating controller
        try {
            $this->controller = new $controllerName;

            if (!method_exists($controllerName, $actionName)) {
                throw new  Exceptions\NoSuchControllerException(
                    "Undefined controller action: {$actionName} of {$controllerName}."
                );
            }
            $this->controllerAction = $actionName;

        } catch (\AutoloaderException $e) {
            throw new  Exceptions\NoSuchControllerException("Undefined controller: {$controllerName}.");
        }
    }

    protected $controllersPath;
    protected $controller;
    protected $controllerAction;
}