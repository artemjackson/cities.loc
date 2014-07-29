<?php

namespace Core;

use Core\MVC\Router\Exceptions\ControllerException;
use Core\MVC\Router\Router;
use Core\MVC\View\View;

//TODO rename to App because Application is too long and you need to write Application all the time
/**
 * Class Application
 * @package Core
 */
final class Application
{

    protected static $_instance; //TODO it is not a PSR

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * @var array
     */
    private static $configuration = array();

    //TODO rename to getConfig getConfiguration is too long
    /**
     * @param null $confName
     * @param null $confOption
     * @return array|null
     */
    public static function getConfiguration($confName = null, $confOption = null)
    {
        if ($confName === null) {
            return self::$configuration;
        }

        if ($confOption === null) {

            //TODO use ternary operator
            if (!empty(self::$configuration[$confName])) {
                return self::$configuration[$confName];
            } else {
                return null;
            }
        }

        //TODO use ternary operator
        if (!empty(self::$configuration[$confName][$confOption])) {
            return self::$configuration[$confName][$confOption];
        } else {
            return null;
        }
    }

    //TODO rename to setConfig
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
     *  Runs application
     */
    public static function run()
    {
        $router = new Router();

        try {
            $router->run();
        } catch (ControllerException $e) {
            $view = new View();
            $view->setTemplate('errors/404');
            $view->render();
            exit;
        }

        $controller = $router->getController();
        $controllerAction = $router->getControllerAction();
        $view = $controller->$controllerAction();

        if (!$view->getTemplate()) {
            $template = self::getTemplateByController($controller, $controllerAction);
            $view->setTemplate($template);
        }
        $view->render();
    }

    /**
     * @param $controller
     * @param $controllerAction
     * @return string
     */
    private static function getTemplateByController($controller, $controllerAction)
    {
        $controllerName = get_class($controller);

        //TODO I think it can be done in more elegant way
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