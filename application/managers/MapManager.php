<?php

namespace Application\Managers;

use Application\Models\MapModel;


/**
 * Class MapManager
 * @package Application\Managers
 */
class MapManager
{
    /**
     * @return mixed
     */
    public static function getRegions()
    {
        $model = new MapModel();
        return $model->getRegions();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getCitiesByRegionId($id)
    {
        $model = new MapModel();
        return $model->getCitiesByRegionId($id);
    }
}