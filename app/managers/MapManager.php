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

    public static function saveCity(array $data = array())
    {
        $cityId = isset($data['city_id']) ? $data['city_id'] : null;
        $cityName = isset($data['city_name']) ? $data['city_name'] : null;
        $regionId = isset($data['region_id']) ? $data['region_id'] : null;
        $latitude = isset($data['latitude']) ? $data['latitude'] : null;
        $longitude = isset($data['longitude']) ? $data['longitude'] : null;
        $model = new RegionModel();
        return $cityId ? $model->updateCity($cityName, $regionId, $cityId, $latitude, $longitude) : $model->saveCity($cityName, $regionId, $latitude, $longitude);
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
        return $result ? $result[0] : null;
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

    public static function getCityCordsById($id)
    {
        $model = new RegionModel();
        $result = $model->getCityCordsById($id);
        return $result[0];
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