<?php

namespace App\Controllers\Helpers;

use App\Managers\UserManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;
use Core\MVC\View\View;

/**
 * Class UsersActionController
 * @package App\Controllers\Helpers
 */
class UsersActionController extends Controller
{
    /**
     * @return AdminView
     */
    public function index()
    {
        return new AdminView(array('users' => UserManager::getAllUsers()));
    }
}