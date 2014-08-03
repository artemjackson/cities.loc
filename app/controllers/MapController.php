<?php

namespace App\Controllers;

use App\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class MapController
 * @package App\Controllers
 */
class MapController extends Controller
{
    /**
     * @return View
     */
    public function indexAction()
    {
        $regions = MapManager::getRegions();
        return new View(array(
            'regions' => $regions //TODO why do we need a regions variable here?
        ));
    }
}