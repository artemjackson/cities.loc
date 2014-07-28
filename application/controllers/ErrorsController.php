<?php

namespace Application\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;
//TODO why do we need this controller?
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