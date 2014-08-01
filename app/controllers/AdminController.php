<?php

namespace App\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class HomeController
 * @package App\Controllers
 */
class AdminController extends Controller
{

    /**
     * @return View
     */
    public function indexAction()
    {
        $view = new View();

        if (!$this->session->loggedIn) {
            $view->setTemplate('errors/403');
            return $view;
        }

        if (! $this->session->loggedIn->hasRole('admin')) {
            $view->setTemplate('errors/403');
            return $view;
        }

        return $view;
    }
}