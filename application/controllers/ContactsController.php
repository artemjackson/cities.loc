<?php

namespace Application\Controllers;

use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class ContactsController
 * @package Application\Controllers
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