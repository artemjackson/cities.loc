<?php

namespace App\Controllers;

use App\Controllers\Helpers\CitiesActionController;
use App\Controllers\Helpers\RegionsActionController;
use App\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\JsonView;

/**
 * Class AjaxController
 * @package App\Controllers
 */
class AjaxController extends Controller
{
    /**
     * @return $this
     */
    public function loadCitiesAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $count = CitiesActionController::itemsPerPage;
            return (new JsonView(
                array(
                    'cities' => MapManager::getCities(($page - 1) * $count, $count)
                )
            ))->setTemplate('admin/cities_table');
        } else {
            return $this->accessForbidden();
        }
    }

    /**
     * @return $this
     */
    public function loadRegionsAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $count = RegionsActionController::itemsPerPage;
            return (new JsonView(
                array(
                    'regions' => MapManager::getRegions(($page - 1) * $count, $count),
                )
            ))->setTemplate('admin/regions_table');

        } else {
            return $this->accessForbidden();
        }
    }

    /**
     * @return $this
     */
    public function updatePaginationAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $type = isset($_POST['type']) ? $_POST['type'] : null;

            $count = 0;
            $itemsPerPage = 1;

            if ($type == 'cities') {
                $count = MapManager::countCities();
                $itemsPerPage = CitiesActionController::itemsPerPage;
            } elseif ($type = 'regions') {
                $count = MapManager::countRegions();
                $itemsPerPage = RegionsActionController::itemsPerPage;
            }

            return (new JsonView(
                array(
                    'activePage' => $page,
                    'itemsTotal' => $count,
                    'itemsPerPage' => $itemsPerPage
                )
            ))->setTemplate("admin/pagination");

        } else {
            return $this->accessForbidden();
        }
    }

    /**
     * @return JsonView
     */
    public function updateCitiesAction()
    {
        if ($this->getRequest()->isAjax()) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            return (new JsonView(
                array(
                    'cities' => MapManager::getCitiesByRegionId($id)
                )
            ))->setTemplate('map/cities_options');

        } else {
            return $this->accessForbidden();
        }
    }

    /**
     * @return $this|bool
     */
    public function regionDeleteAction()
    {
        if ($this->getRequest()->isAjax()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region'])) {
                MapManager::deleteRegion($post['region']) ?
                    $this->flashMessenger->addSuccessMessage("Region was successfully deleted\n") :
                    $this->flashMessenger->addErrorMessage("Region has not been deleted\n");
                return true;
            }
        } else {
            return $this->accessForbidden();
        }
    }

    /**
     * @return $this|bool
     */
    public function cityDeleteAction()
    {
        if ($this->getRequest()->isAjax()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city'])) {
                MapManager::deleteCity($post['city']) ?
                    $this->flashMessenger->addSuccessMessage("City was successfully deleted\n") :
                    $this->flashMessenger->addErrorMessage("City has not been deleted\n");
                return true;
            }
        } else {
            return $this->accessForbidden();
        }
    }
}
