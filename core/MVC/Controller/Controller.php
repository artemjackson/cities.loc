<?php

namespace Core\MVC\Controller;

use Core\HTTP\Request;
use Core\Loggers\FileLogger\FileLogger;
use Core\Managers\FlashMessagesManager;
use Core\MVC\View\View;
use Core\Session\Session;

/**
 * Class Controller
 * @package Core\MVC\Controller
 */
abstract class Controller
{
    /**
     * @var
     */
    protected $request;
    /**
     * @var array
     */
    protected $messages = array();

    /**
     * @var
     */
    protected $flashMessenger;

    /**
     * @var \Core\Session\Session
     */
    protected $session;
    protected $logger;

    /**
     *
     */
    public function __construct()
    {
        $this->flashMessenger = new FlashMessagesManager();
        $this->session = new Session();
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
     * @return \Core\Session\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return $this
     */
    public function accessForbidden()
    {
        $backtrace = debug_backtrace();
        $method = isset($backtrace[1]['function']) ? $backtrace[1]['function'] : '';
        $class = isset($backtrace[1]['class']) ? $backtrace[1]['class'] : '';

        if ($method && $class) {
            $this->logger = new FileLogger("controllers.log");
            $this->logger->error("Unallowed access to '$method' of class '$class'!");
        }
        return (new View())->setTemplate("errors/403");
    }

    /**
     * @return $this
     */
    public function notFound()
    {
        return (new View())->setTemplate("errors/404");
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    /**
     * @param $location
     */
    public function redirect($location = null)
    {
        if (!$location) {
            $currentLocation = $_SERVER['REQUEST_URI'];
            header('Location:' . $currentLocation);
            exit();
        }

        $host = "http://" . $_SERVER['HTTP_HOST'] . '/'; //TODO why do we need this?
        header('Location:' . $host . $location);
        exit();
    }
}

