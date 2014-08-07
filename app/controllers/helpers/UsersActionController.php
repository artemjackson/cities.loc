<?php

namespace App\Controllers\Helpers;

use App\Managers\UserManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;
use Core\MVC\View\View;

class UsersActionController extends Controller
{
    public function index()
    {
        if (Identifier::identity() !== 'admin') { //TODO move to constants. also you can create method isAdmin()
            $view = new View();
            $view->setTemplate('errors/403');
            return $view;
        }

        return new AdminView(array('users' => UserManager::getAllUsers()));
    }
}