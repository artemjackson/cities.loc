<?php

namespace Application\Controllers;

use Application\Managers\MapManager;
use Core\Controller\Controller;
use Core\View\JsonView;

/**
 * Class AjaxController
 * @package Application\Controllers
 */
class AjaxController extends Controller
{
    /**
     * @return JsonView
     */
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
