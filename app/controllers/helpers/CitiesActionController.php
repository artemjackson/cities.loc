<?php

namespace App\Controllers\Helpers;

use App\Form\CityForm;
use App\Managers\MapManager;
use Core\Identifier\Identifier;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;
use Core\MVC\View\View;

class CitiesActionController extends Controller
{
    const itemsPerPage = 10;

    public function index()
    {
        if (Identifier::identity() !== 'admin') {
            $view = new View();
            $view->setTemplate('errors/403');
            return $view;
        }
        return $this->page(1);
    }

    public function page($id = null)
    {
        if (Identifier::identity() !== 'admin') {
            $view = new View();
            $view->setTemplate('errors/403');
            return $view;
        }

        $totalItems = MapManager::countCities();

        if (ceil($totalItems / self::itemsPerPage) < $id) {
            $view = new AdminView();
            $view->setTemplate('errors/404');
            return $view;
        }

        $id = $id > 0 ? $id : 1;

        return new AdminView(array(
            'cities' => MapManager::getCities(
                    ($id - 1) * self::itemsPerPage,
                    self::itemsPerPage
                ),
            'activePage' => $id,
            'itemsTotal' => $totalItems,
            'itemsPerPage' => self::itemsPerPage
        ));
    }

    public function edit($cityId)
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

    public function add()
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

    public function delete()
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