<?php

namespace Core\MVC\View\Helpers;

use App\Controllers\Helpers\CitiesActionController;
use App\Managers\MapManager;

class Pagination extends AbstractHelper
{
    public function help()
    {
        $html = "<ul class=\"nav nav-pills pull-right\">";

        $cities = MapManager::countCities();
        $count = CitiesActionController::COUNT;
        $available = ceil($cities / $count);
        $pages = 5;

        for($i = 1; $i <= $available; $i++){
            $html .= "<li><a href=\"#\" class=\"page\" id={$i}>$i</a></li>";
        }

        $html .= "</ul>";

        return $html;
    }
}