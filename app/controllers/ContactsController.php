<?php

namespace App\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class ContactsController
 * @package App\Controllers
 */
class ContactsController extends Controller
{
    /**
     * @return View
     */
    public function indexAction()
    {
        return new View();
    }
}