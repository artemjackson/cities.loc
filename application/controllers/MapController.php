<?php
namespace Application\Controllers;

use Core\AbstractController;
use Application\Models\MapModel;
use Application\Views\MapView;

class MapController extends AbstractController
{
    public function __construct()
    {
        $this->view = new MapView;
        $this->model = new MapModel;
    }

    public function indexAction()
    {
        $this->view->generate('map.phtml');
    }
}