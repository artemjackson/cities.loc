<?php

namespace Application\Controllers;

use Application\Managers\MapManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class MapController
 * @package Application\Controllers
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
            'regions' => $regions
        ));
    }
}