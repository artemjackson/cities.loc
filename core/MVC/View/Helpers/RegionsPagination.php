<?php

namespace Core\MVC\View\Helpers;

use App\Managers\MapManager;
use Core\App;

class RegionsPagination extends AbstractHelper {
    public function help(){
        include App::getConfig('view', 'templatesPath') . "pagination.phtml";
    }

    public function pagination(){
        $html = "";


        $count = MapManager::countRegions();

        for($i = 1; $i <= $count; $i++){
            $html .= "<li><a href=" . "/admin/regions/page/$i>$i</a></li>";
        }

        return $html;
    }
}