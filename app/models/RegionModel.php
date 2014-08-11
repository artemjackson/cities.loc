<?php

namespace App\Models;

//TODO create model for each table. So RegionModel responsive for return data about regions. CityModel - about cities
use Core\Db\Db;
use Core\MVC\Model\Model;

/**
 * Class MapModel
 * @package App\Models
 */
class RegionModel extends Model
{
    //TODO by the name of this method i expect to get the whole info about region
    public static function getCityCordsById($id)
    {
        $sql = "SELECT latitude, longitude FROM cities WHERE city_id = :id";
        Db::prepare($sql);
        return Db::execute(
            array(
                ':id' => $id
            )
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getRegionByID($id)
    {
        $sql = "SELECT region_name FROM regions WHERE region_id = :region_id";
        Db::prepare($sql);
        return Db::execute(array(':region_id' => $id));
    }

    /**
     * @param null $shift
     * @param null $count
     * @return mixed
     */
    public function getRegions($shift = null, $count = null)
    {
        $sql = "SELECT * FROM regions ORDER BY region_name";

        if ($shift !== null && $count !== null) {
            $sql .= " LIMIT $shift, $count";
        }

        Db::prepare($sql);

        return Db::execute();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCitiesByRegionId($id)
    {
        $sql = "SELECT * FROM cities WHERE region_id = :id ORDER BY city_name";
        Db::prepare($sql);
        return Db::execute(
            array(
                ':id' => $id
            )
        );
    }

    /**
     * @param null $shift
     * @param null $count
     * @return mixed
     */
    public function getCities($shift = null, $count = null)
    {
        $sql = "SELECT cities.city_id, regions.region_name, cities.city_name, cities.latitude, cities.longitude FROM cities JOIN regions ON cities.region_id = regions.region_id ORDER BY cities.city_name";

        if ($shift !== null && $count !== null) {
            $sql .= " LIMIT $shift, $count";
        }

        Db::prepare($sql);

        return Db::execute();
    }

    /**
     * @return mixed
     */
    public function countRegions()
    {
        $sql = "SELECT COUNT(region_id) FROM regions";
        Db::prepare($sql);
        return Db::execute();
    }

    /**
     * @return mixed
     */
    public function countCities()
    {
        $sql = "SELECT COUNT(city_id) FROM cities";
        Db::prepare($sql);
        return Db::execute();
    }

    /**
     * @param $name
     * @param $id
     * @return mixed
     */
    public function updateRegion($name, $id)
    {
        $sql = "UPDATE regions SET region_name = :region_name WHERE region_id = :region_id";
        Db::prepare($sql);
        return Db::execute(array('region_id' => $id, ':region_name' => $name));
    }


    /**
     * @param $name
     * @return mixed
     */
    public function saveRegion($name)
    {
        $sql = "INSERT INTO regions (region_name) VALUES (:region_name)";
        Db::prepare($sql);
        return Db::execute(array(':region_name' => $name));
    }

    //TODO by the name of this method  I expect to get the whole info about the city
    /**
     * @param $id
     * @return mixed
     */
    public function getCityById($id)
    {
        $sql = "SELECT city_name FROM cities WHERE city_id = :city_id";
        Db::prepare($sql);
        return Db::execute(array(':city_id' => $id));

    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCity($id)
    {
        $sql = "DELETE FROM cities WHERE city_id = :city_id";
        Db::prepare($sql);
        return Db::execute(array(':city_id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRegion($id)
    {
        $sql = "DELETE FROM regions WHERE region_id = :region_id";
        Db::prepare($sql);
        return Db::execute(array(':region_id' => $id));
    }

    public function updateCity($cityName, $regionId, $cityId, $latitude, $longitude)
    {
        $sql = "UPDATE cities SET city_name = :city_name, region_id = :region_id,
                latitude = :latitude, longitude = :longitude WHERE city_id = :city_id";
        Db::prepare($sql);
        return Db::execute(
            array(
                ':city_name' => $cityName,
                ':region_id' => $regionId,
                ':city_id' => $cityId,
                ':latitude' => $latitude,
                ':longitude' => $longitude
            )
        );
    }


    public function saveCity($cityName, $regionId, $latitude, $longitude)
    {
        $sql = "INSERT INTO cities (city_name, region_id, latitude, longitude) VALUES (:city_name, :region_id, :latitude, :longitude)";
        Db::prepare($sql);
        return Db::execute(
            array(
                ':city_name' => $cityName,
                ':region_id' => $regionId,
                ':latitude' => $latitude,
                ':longitude' => $longitude
            )
        );
    }

}