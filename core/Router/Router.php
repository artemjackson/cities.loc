<?php

namespace Core\Router;

use Core\Application;
use Core\Exceptions\ConfigurationException;
use Core\Router\Exceptions\ControllerException;

/**
 * Class Router
 * @package Core\Router
 */
class Router
{
    /**
     * @var
     */
    protected static $configuration;

    /**
     * @var
     */
    protected $currentController;

    /**
     * @var
     */
    protected $currentControllerAction;

    /**
     *
     */
    public function __construct()
    {
        if (is_null(self::$configuration)) {
            $conf = Application::getConfiguration()['CONTROLLER_CONFIGURATION'];

            if (!$conf) {
                throw new ConfigurationException('No configuration were specified for' . __CLASS__);
            }
            $this->setConfiguration($conf);
        }
    }

    /**
     * @return mixed
     */
    public function getConfiguration()
    {
        return self::$configuration;
    }

    /**
     * @param mixed
     * @return $this
     */
    protected function setConfiguration($configuration)
    {
        self::$configuration = $configuration;

        foreach ($configuration as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

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
        // Controller and action by default
        $controllerName = $this->defaultController;
        $actionName = $this->defaultAction;

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
        $namespaces = explode('/', $this->controllersPath);

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