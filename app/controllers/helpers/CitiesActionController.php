<?php

namespace App\Controllers\Helpers;

use App\Form\CityForm;
use App\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;

/**
 * Class CitiesActionController
 * @package App\Controllers\Helpers
 */
class CitiesActionController extends Controller
{
    /**
     *
     */
    const itemsPerPage = 10; //TODO PSR?

    /**
     * @return $this|AdminView
     */
    public function index()
    {
        return $this->page(1);
    }

    /**
     * @param null $id
     * @return $this|AdminView
     */
    public function page($id = null)
    {
        $totalItems = MapManager::countCities();

        if (ceil($totalItems / self::itemsPerPage) < $id) {
            return $this->notFound();
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

    /**
     * @param $cityId
     * @return $this
     */
    public function edit($cityId)
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city_name'])) {
                $form = new CityForm($post);
                if ($form->isValid()) {
                    MapManager::saveCity($post['city_name'], $post['region_id'], $post['city_id']) ?
                        $this->flashMessenger->addSuccessMessage("City name was changed successfully\n") :
                        $this->flashMessenger->addErrorMessage("City name has not been changed\n");
                    $this->redirect("admin/cities");
                } else {
                    $this->flashMessenger->addWarningMessages($form->getMessages());
                }
                $this->redirect();
            }
        }
        return (new AdminView(array('cityId' => $cityId)))->setTemplate("admin/editCity");
    }

    /**
     * @return $this
     */
    public function add()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city_name'])) {
                $form = new CityForm($post);
                if ($form->isValid()) {
                    MapManager::saveCity($post['city_name'], $post['region_id']) ?
                        $this->flashMessenger->addSuccessMessage("New city was successfully added\n") :
                        $this->flashMessenger->addErrorMessage("New city hasn't been added\n");
                    $this->redirect("admin/cities");
                } else {
                    $this->flashMessenger->addWarningMessages($form->getMessages());
                    $this->redirect();
                }
            }
        }
        return (new AdminView())->setTemplate("admin/addCity");
    }

    /**
     *
     */
    public function delete()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city'])) {
                MapManager::deleteCity($post['city']) ?
                    $this->flashMessenger->addSuccessMessage("City was successfully deleted\n") :
                    $this->flashMessenger->addErrorMessage("City  has not been changed\n");
                $this->redirect("admin/cities");
            }
        }
    }
}