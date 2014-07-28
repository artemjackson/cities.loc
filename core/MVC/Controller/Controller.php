<?php

namespace Core\MVC\Controller;

use Core\HTTP\Request;

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
     * @return Request
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }
}

