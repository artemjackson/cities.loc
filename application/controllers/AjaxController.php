<?php

namespace Application\Controllers;

use Application\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\JsonView;

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
        $id = $_POST['id']; //TODO always check whether variable is set f.e $id = isset($_POST['id']) ? $_POST['id'] : null;

        $cities = MapManager::getCitiesByRegionId($id);

        $jsonView = new JsonView(array(
            'cities' => $cities
        ));

        $jsonView->setTemplate('map/cities_options');

        return $jsonView;
    }
}
