<?php

namespace App\Managers;

use App\Models\RegionModel;


/**
 * Class MapManager
 * @package App\Managers
 */
class MapManager
{
    /**
     * @return mixed
     */
    public static function getRegions()
    {
        $model = new RegionModel();
        return $model->getRegions();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getCitiesByRegionId($id)
    {
        $model = new RegionModel();
        return $model->getCitiesByRegionId($id);
    }
}