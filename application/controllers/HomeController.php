<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Core\View\View;

class HomeController extends Controller
{
    public function indexAction()
    {
        return new View();
    }
}