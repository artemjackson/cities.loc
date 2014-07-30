<?php

namespace Core\MVC\Controller;

use Core\HTTP\Request;
use Core\Managers\FlashMessagesManager;

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
    protected $flashMessager;

    /**
     *
     */
    public function __construct()
    {
        $this->flashMessager = new FlashMessagesManager();
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
        $host =  "http://" . $_SERVER['HTTP_HOST'] . '/';
        header('Location:' . $host . $location);
        exit();
    }
}

