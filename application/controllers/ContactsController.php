<?php

namespace Application\Controllers;

use Core\AbstractController;
use Application\Views\View;

class ContactsController extends AbstractController
{
    public function indexAction()
    {
        return new View();
    }
}