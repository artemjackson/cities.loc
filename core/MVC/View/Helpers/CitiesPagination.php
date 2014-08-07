<?php

namespace Core\MVC\View\Helpers;

use App\Managers\MapManager;

class CitiesPagination extends AbstractHelper
{
    public function help()
    {
        $activePage = $this->data[0];
        $itemsPerPage = $this->data[1];
        $pagesNumber = $this->data[2];



        return $html;
    }
}