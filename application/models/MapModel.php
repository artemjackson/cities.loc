<?php

namespace Application\Models;

use Core\Database\Database;
use Core\MVC\Model\Model;
//TODO this model works with regions so this must be RegionModel
/**
 * Class MapModel
 * @package Application\Models
 */
class MapModel extends Model
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
        return Database::getConnection()->get($query);
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
        return Database::getConnection()->get($query);
    }
}