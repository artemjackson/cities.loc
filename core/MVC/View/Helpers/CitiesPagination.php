<?php

namespace Core\MVC\View\Helpers;

use App\Managers\MapManager;
use Core\App;

class CitiesPagination extends AbstractPagination {
    public function __construct(array $data = array()){
        parent::__construct($data);
    }
    public function pagination(){
        $page = $this->getPage();

        $allowed = $this->getAllowed();
        $count = MapManager::countCities();
        $pageItems = 10;
        $available = ceil($count / $pageItems);

        $html = "";

        if($page > 1)
        {
            $previous = $page - 1;
            $html .= "<li><a href=" . "/admin/cities/page/1><<</a></li>";
            $html .= "<li><a href=" . "/admin/cities/page/$previous><</a></li>";
        }

        $set = floor($page / $allowed) + 1;

        for($i = $set; $i < $set + $allowed && $i <= $available; $i++){
            $html .= "<li";
            if($page == $i){
                $html .= " class=\"active\"";
            }
            $html .= "><a href=" . "/admin/cities/page/$i>$i</a></li>";

        }

        if($page < $available)
        {
            $next = $page + 1;
            $html .= "<li><a href=" . "/admin/cities/page/$next>></a></li>";
            $html .= "<li><a href=" . "/admin/cities/page/$available>>></a></li>";
        }

        return $html;
    }
}