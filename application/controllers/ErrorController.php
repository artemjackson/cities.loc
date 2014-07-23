<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Core\View\View;

class ErrorController extends Controller
{
    public function error404Action()
    {
        $view = new View();
        $view->setTemplate('error/error404');
        return new $view;
    }
}