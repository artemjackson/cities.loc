<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Core\View\View;

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