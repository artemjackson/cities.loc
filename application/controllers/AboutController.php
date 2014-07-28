<?php

namespace Application\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class AboutController
 * @package Application\Controllers
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