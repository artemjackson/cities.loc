<?php

namespace Application\Controllers;

use Core\Controller\Controller;
use Application\Managers\MapManager;
use Core\View\JsonView;

class AjaxController extends Controller
{
    public function updateCitiesAction()
    {
        $id = $_POST['id'];

        $cities = MapManager::getCitiesByRegionId($id);

        $jsonView = new JsonView(array(
            'cities' => $cities
        ));

        $jsonView->setTemplate('map/cities_options');

        return $jsonView;
    }
}
