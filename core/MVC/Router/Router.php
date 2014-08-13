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
     * @var array
     */
    protected $param = null;

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

        // Getting request URI
        $uri = $_SERVER['REQUEST_URI'];

        $redirection = array();
        foreach (App::getConfig('router', 'redirect') as $key => $value) {
            if (substr_count($uri, $key)) {
                $redirection['path'] = $key;
                $redirection['controller'] = $value;
            }
        }

        // Getting the name of controller if it exists
        if ($redirection) {
            $routes = explode('/', str_replace($redirection['path'], '', $uri));
            $this->setControllerShortName($redirection['path']);
        } else {
            $routes = explode('/', trim($uri, '/'));
            if (!empty($routes[0])) {
                $this->setControllerShortName($routes[0]);
            }
        }

        // Getting the name of action if it exists
        if (!empty($routes[1])) {
            $this->setActionShortName($routes[1]);
        }

        // Checking if there are any params
        if (isset($routes[2])) {
            $this->setParam($routes[2]);
        }

        //  Recreating path to controllers into namespaces
        $namespaces = explode('/', $controllersPath);

        // Namespaces should start from capital letter
        for ($i = 0, $size = count($namespaces); $i < $size; $i++) {
            $namespaces[$i] = ucfirst($namespaces[$i]);
        }

        $prefix = implode('\\', $namespaces);

        // Prefixes addition and taking upper case first letter in controller name
        if ($redirection) {
            $controllerName = $prefix . $redirection['controller'];
        } else {
            $controllerName = $prefix . ucfirst($this->getControllerShortName()) . 'Controller';
        }

        $actionName = $this->getActionShortName() . 'Action';

        //creating controller
        try {
            $testController = new $controllerName;
            $this->setController($testController);
            if (method_exists($testController, $actionName)) {
                $this->action = $actionName;
            } else {
                throw new ControllerException("Undefined method '{$actionName}' in controller '{$controllerName}'.\n");
            }
        } catch (\AutoloaderException $e) {
            throw new  ControllerException("Undefined controller: '{$controllerName}'.\n", 404, $e);
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

    /**
     * @return array
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }

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
}