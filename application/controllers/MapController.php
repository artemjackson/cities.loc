<?php

namespace Application\Controllers;

use Core\AbstractController;
use Application\Views\View;
use Application\Views\JsonView;
use Application\Managers\MapManager;


class MapController extends AbstractController
{
    public function indexAction()
    {
        $regions = MapManager::getRegions();

        return new View(array(
            'regions' => $regions
        ));
    }
}