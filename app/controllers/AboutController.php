<?php

namespace App\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class AboutController
 * @package App\Controllers
 */
class AboutController extends Controller
{
    /**
     * @return View
     */
    public function indexAction()
    {
        return new View();
    }
}