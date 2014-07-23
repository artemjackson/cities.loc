<?php

namespace Application\Controllers;

use Core\AbstractController;
use Application\Managers\MapManager;
use Application\Views\JsonView;

class AjaxController extends AbstractController
{
    public function citiesAction()
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
