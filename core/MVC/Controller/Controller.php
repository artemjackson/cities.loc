<?php

namespace Core\MVC\Controller;

use Core\HTTP\Request;
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

    /**
     *
     */
    public function __construct()
    {
        $this->flashMessenger = new FlashMessagesManager();
        $this->session = new Session();
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

