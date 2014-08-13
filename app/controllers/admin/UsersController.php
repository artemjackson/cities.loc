<?php

namespace App\Controllers\Admin;

use App\Managers\UserManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;
use Core\MVC\View\View;

/**
 * Class UsersActionController
 * @package App\Controllers\Helpers
 */
class UsersController extends Controller
{
    /**
     * @return AdminView
     */
    public function indexAction()
    {
        return new AdminView(array('users' => UserManager::getAllUsers()));
    }
}