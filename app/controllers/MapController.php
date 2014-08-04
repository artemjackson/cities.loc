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
        return new View(array(
            'regions' => MapManager::getRegions()
        ));
    }
}