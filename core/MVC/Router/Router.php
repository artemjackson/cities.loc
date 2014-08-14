<?php

namespace Core\MVC\Router;

use Core\App;
use Core\Loggers\FileLogger\FileLogger;
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
    protected $logger;
    /**
     * @var
     */
    protected $controllerShortName;
    /**
     * @var
     */
    protected $controllerFullName;
    /**
     * @var
     */
    protected $controllersPath;
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

    public function __construct()
    {
        $this->setLogger(new FileLogger("router.log"));
    }

    /**
     * @throws Exceptions\ControllerException
     */
    public function run()
    {
        // initializing with default Controller and Action
        $this->init();

        // Getting request URI
        $uri = $_SERVER['REQUEST_URI'];

        if (!$this->checkRedirection($uri)) { // trying to get redirect if it exists
            $uriParts = explode('/', trim($uri, '/'));

            if (!empty($uriParts[0])) {
                $this->setControllerShortName($uriParts[0]);
            }

            if (!empty($uriParts[0])) {
                $this->setControllerFullName($this->toNamespace($this->getControllersPath()) . ucfirst($uriParts[0]) . 'Controller');
            }

            if (!empty($uriParts[1])) {
                $this->setActionShortName($uriParts[1]);
            }

            if (!empty($uriParts[1])) {
                $this->setAction($uriParts[1] . 'Action');
            }

            if (!empty($uriParts[2])) {
                $this->setParam($uriParts[2]);
            }
        }
        $this->getLogger()->log('Trying redirect: ' . $this->getControllerFullName() . "->" . $this->getAction() . '(' . $this->getParam() . ')');
        $controllerName = $this->getControllerFullName();

        //  trying to create Controller
        try {
            $testController = new $controllerName();
        } catch (\AutoloaderException $e) {
            $this->getLogger()->error("Aborted: Undefined controller: '{$this->getControllerFullName()}'");
            throw new  ControllerException("Undefined controller: '{$this->getControllerFullName()}'.\n", 404, $e);
        }

        // checking action existence
        if (!method_exists($testController, $this->getAction())) {
            $this->getLogger()->error("Aborted: Undefined method '{$this->getAction()}' in controller '{$controllerName}'.\n");
            throw new ControllerException("Undefined method '{$this->getAction()}' in controller '{$controllerName}'.\n");
        }

        $this->setController($testController);
        $this->getLogger()->log("Redirected successfully", FileLogger::SUCCESS);
    }

    /**
     *
     */
    public function init()
    {
        // Controller and action by default
        $this->setControllersPath(App::getConfig('controller', 'controllersPath'));

        $this->setControllerShortName(App::getConfig('controller', 'defaultController'));
        $this->setControllerFullName($this->toNamespace($this->getControllersPath()) . ucfirst($this->getControllerShortName()) . 'Controller');

        $this->setActionShortName(App::getConfig('controller', 'defaultAction'));
        $this->setAction($this->getActionShortName() . 'Action');
    }

    /**
     * @param $directory
     * @return string
     */
    public function toNamespace($directory)
    {
        $namespaceParts = explode('/', $directory);

        // Namespaces should start from capital letter
        foreach ($namespaceParts as &$part) {
            $part = ucfirst($part);
        }

        return implode('\\', $namespaceParts);
    }

    /**
     * @return mixed
     */
    public function getControllersPath()
    {
        return $this->controllersPath;
    }

    /**
     * @param $controllersPath
     * @return $this
     */
    public function setControllersPath($controllersPath)
    {
        $this->controllersPath = $controllersPath;
        return $this;
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
     * @param $uri
     * @return bool
     */
    public function checkRedirection($uri)
    {
        foreach (App::getConfig('router', 'redirect') as $key => $value) {
            if (substr_count($uri, $key)) {
                $shortNameParts = explode('\\', str_replace('Controller', '', $value));
                foreach ($shortNameParts as &$part) {
                    $part = lcfirst($part);
                }
                $this->setControllerShortName(implode($shortNameParts, DIRECTORY_SEPARATOR));
                $this->setControllerFullName($this->toNamespace($this->getControllersPath()) . $value);

                // Getting action and parameter
                $uri = str_replace($key, '', $uri);
                $uriParts = explode('/', $uri);

                if (!empty($uriParts[0])) {
                    $this->setActionShortName($uriParts[0]);
                }

                if (!empty($uriParts[0])) {
                    $this->setAction($uriParts[0] . 'Action');
                }

                if (!empty($uriParts[1])) {
                    $this->setParam($uriParts[1]);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return mixed
     */
    public function getControllerFullName()
    {
        return $this->controllerFullName;
    }

    /**
     * @param $controllerFullName
     * @return $this
     */
    public function setControllerFullName($controllerFullName)
    {
        $this->controllerFullName = $controllerFullName;
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