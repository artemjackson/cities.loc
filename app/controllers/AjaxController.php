<?php

namespace App\Controllers;

use App\Controllers\Helpers\CitiesActionController;
use App\Controllers\Helpers\RegionsActionController;
use App\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\JsonView;
use Core\MVC\View\View;

/**
 * Class AjaxController
 * @package App\Controllers
 */
class AjaxController extends Controller
{
    public function loadCitiesAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $count = CitiesActionController::itemsPerPage;
            $jsonView = new JsonView(
                array(
                    'cities' => MapManager::getCities(($page - 1) * $count, $count)
                )
            );
            $jsonView->setTemplate('admin/cities_table');
            return $jsonView;

        } else {
            return $this->accessForbiddenPage();
        }
    }

    public function accessForbiddenPage()
    {
        $view = new View();
        $view->setTemplate("errors/403");
        return $view;
    }

    public function loadRegionsAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $count = RegionsActionController::itemsPerPage;
            $jsonView = new JsonView(
                array(
                    'regions' => MapManager::getRegions(($page - 1) * $count, $count),
                )
            );
            $jsonView->setTemplate('admin/regions_table');
            return $jsonView;

        } else {
            return $this->accessForbiddenPage();
        }
    }

    public function updatePaginationAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $type = isset($_POST['type']) ? $_POST['type'] : null;

            if ($type == 'cities') {
                $count = MapManager::countCities();
                $itemsPerPage = CitiesActionController::itemsPerPage;
            } elseif ($type = 'regions') {
                $count = MapManager::countRegions();
                $itemsPerPage = RegionsActionController::itemsPerPage;
            }


            $jsonView = new JsonView();
            $jsonView->setData(
                array(
                    'activePage' => $page,
                    'itemsTotal' => $count,
                    'itemsPerPage' => $itemsPerPage
                )
            );
            $jsonView->setTemplate("admin/pagination");

            return $jsonView;

        } else {
            return $this->accessForbiddenPage();
        }
    }

    //TODO move it to abstract controller. Something like forbiddenAction. As well as notFoundAction

    /**
     * @return JsonView
     */
    public function updateCitiesAction()
    {
        if ($this->getRequest()->isAjax()) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $cities = MapManager::getCitiesByRegionId($id);

            $jsonView = new JsonView(
                array(
                    'cities' => $cities
                )
            );

            $jsonView->setTemplate('map/cities_options');
            return $jsonView;

        } else {
            return $this->accessForbiddenPage();
        }
    }

    public function regionDeleteAction()
    {
        if ($this->getRequest()->isAjax()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['region'])) {
                MapManager::deleteRegion($post['region']) ?
                    $this->flashMessager->addSuccessMessage("Region was successfully deleted\n") :
                    $this->flashMessager->addErrorMessage("Region has not been deleted\n");
                return true;
            }
        } else {
            return $this->accessForbiddenPage();
        }
    }

    public function cityDeleteAction()
    {
        if ($this->getRequest()->isAjax()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['city'])) {
                MapManager::deleteCity($post['city']) ?
                    $this->flashMessager->addSuccessMessage("City was successfully deleted\n") :
                    $this->flashMessager->addErrorMessage("City has not been deleted\n");
                return true;
            }
        } else {
            return $this->accessForbiddenPage();
        }
    }
}
