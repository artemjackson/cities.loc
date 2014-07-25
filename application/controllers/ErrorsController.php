<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Core\View\View;

/**
 * Class ErrorController
 * @package Application\Controllers
 */
class ErrorsController extends Controller
{
    /**
     * @return View
     */
    public function error404Action()
    {
        return new View();
    }
}