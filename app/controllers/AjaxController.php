<?php

namespace App\Controllers;

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
     * @return JsonView
     */
    public function updateCitiesAction()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        $cities = MapManager::getCitiesByRegionId($id);

        $jsonView = new JsonView(array(
            'cities' => $cities
        ));

        $jsonView->setTemplate('map/cities_options');

        return $jsonView;
    }
}
