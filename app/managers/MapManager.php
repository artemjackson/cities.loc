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
    /**
     * @param $id
     * @return null
     */
    public static function getRegionByID($id)
    {
        $model = new RegionModel();
        $result = $model->getRegionByID($id);
        return $result ? $result[0]['region_name'] : null;
    }

    /**
     * @param null $shift
     * @param null $count
     * @return mixed
     */
    public static function getRegions($shift = null, $count = null)
    {
        $model = new RegionModel();
        return $model->getRegions($shift, $count);
    }

    /**
     * @param $name
     * @param null $id
     * @return mixed
     */
    public static function saveRegion($name, $id = null) 
    {
        $model = new RegionModel();
        return $id ? $model->updateRegion($name, $id) : $model->saveRegion($name);
    }

    /**
     * @param $cityName
     * @param $regionId
     * @param null $cityId
     * @return mixed
     */
    public static function saveCity($cityName, $regionId, $cityId = null)
    {
        $model = new RegionModel();
        return $cityId ? $model->updateCity($cityName, $regionId, $cityId) : $model->saveCity($cityName, $regionId);
    }

    //TODO see comment to getRegionByID
    /**
     * @param $id
     * @return null
     */
    public static function getCityById($id)
    {
        $model = new RegionModel();
        $result = $model->getCityById($id);
        return $result ? $result[0]['city_name'] : null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function deleteCity($id)
    {
        $model = new RegionModel();
        return $model->deleteCity($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function deleteRegion($id)
    {
        $model = new RegionModel();
        return $model->deleteRegion($id);
    }

    /**
     * @return mixed
     */
    public static function countRegions()
    {
        $model = new RegionModel();
        return current($model->countRegions()[0]);
    }

    /**
     * @return mixed
     */
    public static function countCities()
    {
        $model = new RegionModel();
        return current($model->countCities()[0]);
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

    /**
     * @param null $shift
     * @param null $count
     * @return mixed
     */
    public static function getCities($shift = null, $count = null)
    {
        $model = new RegionModel();
        return $model->getCities($shift, $count);
    }
}