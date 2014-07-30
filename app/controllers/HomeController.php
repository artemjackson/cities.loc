<?php

namespace App\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class HomeController
 * @package App\Controllers
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