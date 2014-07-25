<?php

namespace Core;

use Core\Router\Exceptions\ControllerException;
use Core\Router\Router;

/**
 * Class Application
 * @package Core
 */
class Application
{
    /**
     * @var
     */
    private static $_instance;

    /**
     * @var array
     */
    private static $configuration = array();

    /**
     * @var
     */
    private static $router;

    /**
     *  Singleton patter realization of Application
     */
    private function __construct()
    {
    }

    /**
     * @return array
     */
    public static function getConfiguration()
    {
        return self::$configuration;
    }

    /**
     * @param array $configuration
     * @return \Core\Application
     */
    public static function setConfiguration(array $configuration = array())
    {
        self::$configuration = $configuration;
        return self::getInstance();
    }

    /**
     * @return Application
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     *  Runs application
     */
    public static function run()
    {
        self::$router = new Router();
        try {
            self::$router->run();
        } catch (ControllerException $e) {
            self::error404();
        }


        $controller = self::$router->getController();
        $controllerAction = self::$router->getControllerAction();
        $view = $controller->$controllerAction();

        if (!$view->getTemplate()) {
            $template = self::getTemplateByController($controller, $controllerAction);
            $view->setTemplate($template);
        }
        $view->render();
    }

    /**
     *
     */
    protected static function error404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . 'errors/error404');
    }

    /**
     * @param $controller
     * @param $controllerAction
     * @return string
     */
    protected static function getTemplateByController($controller, $controllerAction)
    {
        $controllerName = get_class($controller);

        // Getting controller name without namespaces
        $controllerName = substr($controllerName, strripos($controllerName, "\\") + 1);
        $controllerName = substr($controllerName, 0, strripos($controllerName, "Controller"));

        // Getting action name
        $actionName = substr($controllerAction, 0, strripos($controllerAction, "Action"));

        // Creating template
        $template = $controllerName . DIRECTORY_SEPARATOR . $actionName;

        // Template should be in lower case
        $template = strtolower($template);

        return $template;
    }
}