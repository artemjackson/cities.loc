<?php

namespace App\Controllers;

use App\Form\CityForm;
use App\Form\RegionForm;
use App\Managers\MapManager;
use App\Managers\UserManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

//TODO refactor this controller. It must be separated into different controllers (CityController, RegionController, UserController)
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

        if (Identifier::identity() !== 'admin') { //TODO move to constants. also you can create method isAdmin()
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin'); // TODO you are setting it in every action it must be refactored
        return $view;
    }

    public function __call($name, array $arguments = array()){
        $helperName = __NAMESPACE__ . "\\Helpers\\" . ucfirst($name) . "Controller";
        $helper = new $helperName();

        $action = isset($arguments[0][0]) ? $arguments[0][0] : 'index';
        unset($arguments[0][0]);
        $args = isset($arguments[0][1]) ? $arguments[0][1] : null;

        return $helper->$action($args);
    }

}