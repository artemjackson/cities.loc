<?php

namespace Application\Controllers;

use Application\Managers\MapManager;
use Core\Controller\Controller;
use Core\View\View;


class MapController extends Controller
{
    public function indexAction()
    {
        $regions = MapManager::getRegions();
        return new View(array(
            'regions' => $regions
        ));
    }
}