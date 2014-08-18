<?php

namespace App\Controllers\Admin;

use App\Form\CityForm;
use App\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;

/**
 * Class CitiesActionController
 * @package App\Controllers\Helpers
 */
class CitiesController extends Controller
{
    /**
     *
     */
    const itemsPerPage = 10; //TODO PSR?

    /**
     * @return $this|AdminView
     */
    public function indexAction()
    {
        return $this->pageAction(1);
    }

    /**
     * @param null $id
     * @return $this|AdminView
     */
    public function pageAction($id = null)
    {
        $totalItems = MapManager::countCities();

        if (ceil($totalItems / self::itemsPerPage) < $id) {
            return $this->notFound();
        }

        $id = $id > 0 ? $id : 1;

        return (new AdminView(array(
            'cities' => MapManager::getCities(
                    ($id - 1) * self::itemsPerPage,
                    self::itemsPerPage
                ),
            'activePage' => $id,
            'itemsTotal' => $totalItems,
            'itemsPerPage' => self::itemsPerPage
        )))->setTemplate('admin/cities/index/');
    }

    /**
     * @param $cityId
     * @return $this
     */
    public function editAction($cityId)
    {
        if ($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();
            if (isset($post['city_name'])) {
                $form = new CityForm($post);
                if ($form->isValid()) {
                    MapManager::saveCity($post) ?
                        $this->flashMessenger->addSuccessMessage("City name was changed successfully\n") :
                        $this->flashMessenger->addErrorMessage("City name has not been changed\n");
                } else {
                    $this->flashMessenger->addWarningMessages($form->getMessages());
                }
                $this->redirect('admin/cities/');
            }

        }
        return (new AdminView(array('cityId' => $cityId)));
    }

    /**
     * @return $this
     */
    public function addAction()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city_name'])) {
                $form = new CityForm($post);
                if ($form->isValid()) {
                    MapManager::saveCity($post) ?
                        $this->flashMessenger->addSuccessMessage("New city was successfully added\n") :
                        $this->flashMessenger->addErrorMessage("New city hasn't been added\n");
                    $this->redirect("admin/cities/");
                } else {
                    $this->flashMessenger->addWarningMessages($form->getMessages());
                    $this->redirect();
                }
            }
        }
        return (new AdminView());
    }

    /**
     *
     */
    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city'])) {
                MapManager::deleteCity($post['city']) ?
                    $this->flashMessenger->addSuccessMessage("City was successfully deleted\n") :
                    $this->flashMessenger->addErrorMessage("City  has not been changed\n");
                $this->redirect("admin/cities/");
            }
        }
    }
}