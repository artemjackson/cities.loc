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
    /**
     * @return mixed
     */
    public function getRegions()
    {
        $sql = "SELECT * FROM regions ORDER BY name";
        Db::prepare($sql);
        return Db::execute();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCitiesByRegionId($id)
    {
        $sql = "SELECT * FROM cities WHERE region_id = :id ORDER BY name";
        Db::prepare($sql);
        return Db::execute(
            array(
                ':id' => $id
            )
        );
    }
}