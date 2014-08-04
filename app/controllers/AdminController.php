<?php

namespace App\Controllers;

use App\Managers\MapManager;
use App\Managers\UserManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class HomeController
 * @package App\Controllers
 */
class AdminController extends Controller
{

    public function editAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');

        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['region_name'])) {
                MapManager::safeRegion($post['region_name'], $post['region_id']);
                $this->flashMessager->addSuccessMessage("Region name was changed successfully\n");
                $this->redirect("admin/regions");
            }

            if (isset($post['city_name'])) {
                MapManager::safeCity($post['city_name'], $post['region_id'], $post['city_id']);
                $this->flashMessager->addSuccessMessage("City name was changed successfully\n");
                $this->redirect("admin/cities");
            }

        } else {
            $get = $this->getRequest()->getGet();

            if (!$get) {
                $view->setTemplate('errors/403');
                return $view;
            }

            if (isset($get['region'])) {
                $view->setTemplate("admin/editRegion");
                $view->setData(array('regionId' => $get['region']));
                return $view;
            }

            if (isset($get['city'])) {
                $view->setTemplate("admin/editCity");
                $view->setData(array('cityId' => $get['city']));
                return $view;
            }
        }
    }

    public function deleteAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');

        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['region'])) {
                MapManager::deleteRegion($post['region']);
                $this->flashMessager->addSuccessMessage("Region was successfully deleted\n");
                $this->redirect("admin/regions");
            }

            if (isset($post['city'])) {
                MapManager::deleteCity($post['city']);
                $this->flashMessager->addSuccessMessage("City was successfully deleted\n");
                $this->redirect("admin/cities");
            }
        }

        $view->setTemplate('errors/403');
        return $view;
    }

    /**
     * @return View
     */
    public function indexAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');
        return $view;
    }

    public function usersAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');
        $view->setData(array('users' => UserManager::getAllUsers()));

        return $view;
    }

    public function regionsAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');
        $view->setData(array('regions' => MapManager::getRegions()));

        return $view;
    }

    public function citiesAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');
        $view->setData(array('cities' => MapManager::getAllCities()));

        return $view;
    }
}