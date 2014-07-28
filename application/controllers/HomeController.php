<?php

namespace Application\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class HomeController
 * @package Application\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return View
     */
    public function indexAction()
    {
        return new View();
    }
}