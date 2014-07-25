<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Core\View\View;

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