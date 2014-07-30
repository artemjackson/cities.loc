<?php

namespace App\Models;

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
        $query = array(
            'select' => '*',
            'from' => 'regions',
            'orderBy' => 'name',
        );
        // equivalent of SELECT * FROM region ORDER BY name;
        return Db::getConnection()->get($query);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCitiesByRegionId($id)
    {
        $query = array(
            'select' => 'id, name',
            'from' => 'cities',
            'where' => 'region_id',
            'whereValue' => $id,
            'orderBy' => 'name',
        );
        // equivalent of SELECT * FROM region WHERE region_id = '$id' ORDER BY name;
        return Db::getConnection()->get($query);
    }
}