<?php

namespace Core\MVC\View;

use Core\Session\Session;

class ViewHelper
{
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }
}