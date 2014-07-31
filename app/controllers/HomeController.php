<?php

namespace App\Controllers;

use App\Form\SingInForm;
use App\Managers\UserManager;
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
        $view = new View();
        return $view;
    }
}