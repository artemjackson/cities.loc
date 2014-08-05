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

    public function usersAction()
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') { //TODO move to constants. also you can create method isAdmin()
            $view->setTemplate('errors/403');
            return $view;
        }

        $view->setLayout('admin');
        $view->setData(array('users' => UserManager::getAllUsers()));

        return $view;
    }

    public function regionsAction(array $params = array())
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') { //TODO move to constants. also you can create method isAdmin()
            $view->setTemplate('errors/403');
            return $view;
        }
        //TODO refactor
        if (isset($params[0])) {
            switch ($params[0]) {
                case 'edit':
                    return $this->editRegion($params[1]);
                case 'add':
                    return $this->addRegion();
                case 'delete':
                    $this->deleteRegion();
            }
        }

        $view->setLayout('admin');
        $view->setData(array('regions' => MapManager::getRegions()));

        return $view;
    }

    public function editRegion($regionId)
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['region_name'])) {
                $form = new RegionForm($post);
                if ($form->isValid()) {
                    MapManager::safeRegion($post['region_name'], $post['region_id']) ? //TODO safeRegion????  do you mean saveRegion
                        $this->flashMessager->addSuccessMessage("Region name was changed successfully\n") : //Suggest to wrap $this->flashMessager->addSuccessMessage to $this->success('message')
                        $this->flashMessager->addErrorMessage("Region name has not been changed\n");//Suggest to wrap $this->flashMessager->addErrorMessage to $this->error('message')
                    $this->redirect("admin/regions");
                } else {
                    $this->flashMessager->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }

        $view = new View();
        $view->setLayout('admin');
        $view->setTemplate("admin/editRegion"); //TODO why do you use "" insteadof ''
        $view->setData(array('regionId' => $regionId));

        return $view;
    }

    public function addRegion()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region_name'])) {
                $form = new RegionForm($post);
                if ($form->isValid()) {
                    MapManager::safeRegion($post['region_name']) ?
                        $this->flashMessager->addSuccessMessage("New region was successfully added\n") :
                        $this->flashMessager->addErrorMessage("New region hasn't been added\n");
                    $this->redirect("admin/regions");
                } else {
                    $this->flashMessager->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }

        $view = new View();
        $view->setLayout('admin');
        $view->setTemplate("admin/addRegion");
        return $view;
    }

    public function deleteRegion()
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['region'])) {
                MapManager::deleteRegion($post['region']) ?
                    $this->flashMessager->addSuccessMessage("Region was successfully deleted\n") :
                    $this->flashMessager->addErrorMessage("Region has not been deleted\n");

                $this->redirect("admin/regions");
            }
        }
    }

    public function citiesAction(array $params = array())
    {
        $view = new View();

        if (Identifier::identity() !== 'admin') {
            $view->setTemplate('errors/403');
            return $view;
        }

        if (isset($params[0])) {
            switch ($params[0]) {
                case 'edit':
                    return $this->editCity($params[1]);
                case 'add':
                    return $this->addCity();
                case 'delete':
                    return $this->deleteCity();
            }
        }

        $view->setLayout('admin');
        $view->setData(array('cities' => MapManager::getAllCities()));

        return $view;
    }

    public function editCity($cityId)
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city_name'])) {
                $form = new CityForm($post);
                if ($form->isValid()) {
                    MapManager::safeCity($post['city_name'], $post['region_id'], $post['city_id']) ?
                        $this->flashMessager->addSuccessMessage("Region name was changed successfully\n") :
                        $this->flashMessager->addErrorMessage("Region name has not been changed\n");
                    $this->redirect("admin/cities");
                } else {
                    $this->flashMessager->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }

        $view = new View();
        $view->setLayout('admin');
        $view->setTemplate("admin/editCity");
        $view->setData(array('cityId' => $cityId));

        return $view;
    }

    public function addCity()
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['city_name'])) {

                $form = new CityForm($post);
                if ($form->isValid()) {
                    MapManager::safeCity($post['city_name'], $post['region_id']) ?
                        $this->flashMessager->addSuccessMessage("New city was successfully added\n") :
                        $this->flashMessager->addErrorMessage("New city hasn't been added\n");
                    $this->redirect("admin/cities");
                } else {
                    $this->flashMessager->addWarningMessages($form->getMessages());
                    $this->redirect();
                }

            }
        }

        $view = new View();
        $view->setLayout('admin');
        $view->setTemplate("admin/addCity");
        return $view;
    }

    public function deleteCity()
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if (isset($post['city'])) {

                MapManager::deleteCity($post['city']) ?
                    $this->flashMessager->addSuccessMessage("City was successfully deleted\n") :
                    $this->flashMessager->addErrorMessage("City  has not been changed\n");
                $this->redirect("admin/cities");
            }
        }
    }
}