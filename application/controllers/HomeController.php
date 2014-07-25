<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Core\View\View;

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