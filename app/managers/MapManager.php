<?php

namespace App\Managers;

use App\Models\RegionModel;


/**
 * Class MapManager
 * @package App\Managers
 */
class MapManager
{
    //TODO what does this method do? Returns the name of the region or the whole region info
    public static function getRegionByID($id)
    {
        $model = new RegionModel();
        $result = $model->getRegionByID($id);
        return $result ? $result[0]['region_name'] : null;
    }

    /**
     * @return mixed
     */
    public static function getRegions()
    {
        $model = new RegionModel();
        return $model->getRegions();
    }

    public static function safeRegion($name, $id = null) //TODO safeRegion????
    {
        $model = new RegionModel();
        return $id ? $model->updateRegion($name, $id) : $model->safeRegion($name);
    }

    public static function safeCity($cityName, $regionId, $cityId = null) //TODO safeCity????
    {
        $model = new RegionModel();
        return $cityId ? $model->updateCity($cityName, $regionId, $cityId) : $model->safeCity($cityName, $regionId);
    }

    //TODO see comment to getRegionByID
    public static function getCityById($id)
    {
        $model = new RegionModel();
        $result = $model->getCityById($id);
        return $result ? $result[0]['city_name'] : null;
    }

    public static function deleteCity($id)
    {
        $model = new RegionModel();
        return  $model->deleteCity($id);
    }

    public static function deleteRegion($id)
    {
        $model = new RegionModel();
        return $model->deleteRegion($id);
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

    public static function getAllCities()
    {
        $model = new RegionModel();
        return $model->getAllCities();
    }
}