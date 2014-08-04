<?php

namespace Core;

use Core\MVC\Router\Exceptions\ControllerException;
use Core\MVC\Router\Router;
use Core\MVC\View\View;

/**
 * Class App
 * @package Core
 */
final class App
{
    /**
     * @var
     */
    protected static $instance;
    /**
     * @var array
     */
    private static $config = array();

    /**
     *
     */
    protected function __construct()
    {
    }

    /**
     * @param null $confName
     * @param null $confOption
     * @return array|null
     */
    public static function getConfig($confName = null, $confOption = null)
    {
        if ($confName !== null) {

            if ($confOption !== null) {
                return !empty(self::$config[$confName][$confOption]) ? self::$config[$confName][$confOption] : null;
            }

            return !empty(self::$config[$confName]) ? self::$config[$confName] : null;
        }

        return self::$config;
    }

    /**
     * @param array $config
     * @return \Core\App
     */
    public static function setConfig(array $config = array())
    {
        self::$config = !empty(self::$config) ? array_merge(self::$config, $config) : $config;
        return self::getInstance();
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     *  Runs App
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
        $action = $router->getAction();
        $view = $controller->$action();

        if (!$view->getTemplate()) {
            $folder = $router->getControllerShortName();
            $file = $router->getActionShortName();
            $template = $folder . DIRECTORY_SEPARATOR . $file;
            $view->setTemplate($template);
        }
        $view->render();
    }
}