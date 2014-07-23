<?php

namespace Application\Managers;

use Application\Models\MapModel;


class MapManager
{
    public static function getRegions()
    {
        $model = new MapModel();
        return $model->getRegions();
    }

    public static function getCitiesByRegionId($id)
    {
        $model = new MapModel();
        return $model->getCitiesByRegionId($id);
    }
}