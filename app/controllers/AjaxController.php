<?php

namespace App\Controllers;

use App\Controllers\Admin\CitiesController;
use App\Controllers\Admin\RegionsController;
use App\Managers\MapManager;
use Core\Loggers\FileLogger\FileLogger;
use Core\MVC\Controller\Controller;
use Core\MVC\View\JsonView;

/**
 * Class AjaxController
 * @package App\Controllers
 */
class AjaxController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logger = new FileLogger("ajax_controller.log");
    }
    /**
     * @return $this
     */

    public function findAnyMatchesAction()
    {
        if ($this->getRequest()->isAjax()) {
            $needle = isset($_POST['needle']) ? $_POST['needle'] : null;
            return (new JsonView(
                array(
                    'cities' => MapManager::findAnyMatches($needle)
                )
            ))->setTemplate('admin/cities/cities_table');

        } else {
            return $this->accessForbidden();
        }
    }

     public function loadCitiesAction()
    {
        if ($this->getRequest()->isAjax()) {
            $page = isset($_POST['activePage']) ? $_POST['activePage'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : 'ASC';
            $column = isset($_POST['column']) ? $_POST['column'] : null;

            $count = CitiesController::itemsPerPage;

            return (new JsonView(
                array(
                    'cities' => MapManager::getCities(($page - 1) * $count, $count, $column, $order)
                )
            ))->setTemplate('admin/cities/cities_table');
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
            $count = RegionsController::itemsPerPage;
            return (new JsonView(
                array(
                    'regions' => MapManager::getRegions(($page - 1) * $count, $count),
                )
            ))->setTemplate('admin/regions/regions_table');

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
                $itemsPerPage = CitiesController::itemsPerPage;
            } elseif ($type = 'regions') {
                $count = MapManager::countRegions();
                $itemsPerPage = RegionsController::itemsPerPage;
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
        /*
         *  TODO
         *  if (!$this->getRequest()->isAjax()) {
         *      return $this->accessForbidden();
         *  }
         *
         * */
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
