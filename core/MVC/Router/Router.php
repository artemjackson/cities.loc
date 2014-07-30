<?php

namespace Core\MVC\Router;

use Core\App;
use Core\MVC\Router\Exceptions\ControllerException;


/**
 * Class Router
 * @package Core\MVC\Router
 */
class Router
{
    /**
     * @var
     */
    protected $controller;

    /**
     * @var
     */
    protected $controllerShortName;

    /**
     * @var
     */
    protected $action;

    /**
     * @var
     */
    protected $actionShortName;

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param $controller
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @throws Exceptions\ControllerException
     */
    public function run()
    {
        $defaultController = App::getConfig('controller', 'defaultController');
        $defaultAction = App::getConfig('controller', 'defaultAction');
        $controllersPath = App::getConfig('controller', 'controllersPath');

        // Controller and action by default
        $this->setControllerShortName($defaultController);
        $this->setActionShortName($defaultAction);

        // Separating request URI
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Getting the name of controller if it exists
        if (!empty($routes[1])) {
            $this->setControllerShortName($routes[1]);
        }

        // Getting the name of action if it exists
        if (!empty($routes[2])) {
            $this->setActionShortName($routes[2]);
        }

        //  Recreating path to controllers into namespaces
        $namespaces = explode('/', $controllersPath);

        // Namespaces should start from capital letter
        for ($i = 0, $size = count($namespaces); $i < $size; $i++) {
            $namespaces[$i] = ucfirst($namespaces[$i]);
        }

        $prefix = implode('\\', $namespaces);

        // Prefixes addition and taking upper case first letter in controller name
        $controllerName = $prefix . ucfirst($this->getControllerShortName()) . 'Controller';
        $actionName = $this->getActionShortName() . 'Action';

        //creating controller
        try {
            $this->setController(new $controllerName);

            if (!method_exists($this->getController(), $actionName)) {
                throw new  ControllerException(
                    "Undefined controller action: {$actionName} in {$controllerName}.\n"
                );
            }

            $this->action = $actionName;

        } catch (\AutoloaderException $e) {
            throw new  ControllerException("Undefined controller: {$controllerName}.\n", 404, $e);
        }
    }

    /**
     * @return mixed
     */
    public function getControllerShortName()
    {
        return $this->controllerShortName;
    }

    /**
     * @param $controllerShortName
     * @return $this
     */
    public function setControllerShortName($controllerShortName)
    {
        $this->controllerShortName = $controllerShortName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionShortName()
    {
        return $this->actionShortName;
    }

    /**
     * @param $actionShortName
     * @return $this
     */
    public function setActionShortName($actionShortName)
    {
        $this->actionShortName = $actionShortName;
        return $this;
    }
}