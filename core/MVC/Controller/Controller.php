<?php

namespace Core\MVC\Controller;

use Core\HTTP\Request;
use Core\Managers\FlashMessagesManager;
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
    protected $flashMessager; //TODO incorrect spelling (flashMessenger)

    /**
     * @var \Core\Session\Session
     */
    protected $session;

    /**
     *
     */
    public function __construct()
    {
        $this->flashMessager = new FlashMessagesManager();
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
    public function redirect($location)
    {
        $host = "http://" . $_SERVER['HTTP_HOST'] . '/'; //TODO why do we need this?
        header('Location:' . $host . $location);
        exit();
    }
}

