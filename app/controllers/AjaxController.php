<?php

namespace App\Controllers;

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

    //TODO move it to abstract controller. Something like forbiddenAction. As well as notFoundAction
    public function accessForbiddenPage()
    {
        $view = new View();
        $view->setTemplate("errors/403");
        return $view;
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
            }
            return true;
        } else {
            return $this->accessForbiddenPage();
        }
    }
}
