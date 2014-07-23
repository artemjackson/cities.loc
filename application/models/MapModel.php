<?php
namespace Application\Models;

use Core\AbstractModel;

class MapModel extends AbstractModel
{
    public function __construct()
    {
        $this->connectDB('cities', 'jackson', '9951');
    }

    public function __destruct()
    {
        $this->unconnectDB();
    }

    public function getRegions()
    {
        $statementHandler = $this->databaseHandler->prepare('SELECT * FROM regions ORDER BY name;');

        if ($statementHandler->execute()) {
            return $statementHandler->fetchAll();
        }
    }

    public function getCitiesByRegionId($region_id)
    {
        $statementHandler = $this->databaseHandler->prepare(
            "SELECT id, name FROM cities WHERE region_id='{$region_id}' GROUP BY name;"
        );

        if ($statementHandler->execute()) {
            return $statementHandler->fetchAll();
        }
    }

    private function connectDB($dbname, $user, $pass)
    {
        try {
            $this->databaseHandler = new \PDO("mysql:host=localhost;dbname={$dbname}", $user, $pass);
            $this->databaseHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die($e->errorInfo);
        }
    }

    private function unconnectDB()
    {
        $this->databaseHandler = null;
    }

    private $databaseHandler;
}