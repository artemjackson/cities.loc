<?php

namespace Application\Models;


use Application\Models\Database\Database;
use Core\Model\Model;

/**
 * Class MapModel
 * @package Application\Models
 */
class MapModel extends Model
{
    /**
     * @var
     */
    protected $database;

    /**
     *
     */
    public function __construct()
    {
        $this->databse = new Database();
        $this->databse->connect();
    }


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
        return $this->databse->get($query);
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
        return $this->databse->get($query);
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->databse->disconnect();
    }
}