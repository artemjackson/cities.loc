<?php

namespace Application\Models\Database;

use Application\Models\Database\Exceptions\DatabaseException;
use Core\Application;
use Core\Exceptions\ConfigurationException;


/**
 * Class Database
 * @package Application\Models\Database
 */
class Database
{
    /**
     * @var
     */
    protected $databaseHandler;

    /**
     *
     */
    public function __construct()
    {
        $configuration = Application::getConfiguration()['DATABASE_CONFIGURATION'];
        if (!$configuration) {
            throw new ConfigurationException('No configuration were specified for ' . __CLASS__);
        }
        $this->setConfiguration($configuration);
    }

    /**
     * @param array $configuration
     * @return $this
     */
    protected function setConfiguration(array $configuration = array())
    {
        // Creating variables into class
        foreach ($configuration as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * @throws Exceptions\DatabaseException
     */
    public function connect()
    {
        $db = $this->databaseType . ":dbname=" . $this->databaseName . ";";
        $host = "host=" . $this->hostName;
        $dsn = $db . $host;
        $user = $this->userName;
        $password = $this->password;

        try {
            $this->databaseHandler = new \PDO($dsn, $user, $password);
            $this->databaseHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new DatabaseException("Failed to connect to '{$this->databaseName}' database", 403, $e);
        }
    }

    /**
     * @param array $array
     * @return mixed
     */
    public function get(array $array = array())
    {
        //return $this->getter($array);
        $query = '';

        if ($array['select']) {
            $query .= "SELECT " . $array['select'];
        }

        if ($array['from']) {
            $query .= " FROM " . $array['from'];
        }

        if (!empty($array['where'])) {
            $query .= " WHERE " . $array['where'];
        }

        if (!empty($array['whereValue'])) {
            $query .= " = :whereValue";
        }

        if (!empty($array['orderBy'])) {
            $query .= " ORDER BY " . $array['orderBy'];
        }

        $statementHandler = $this->databaseHandler->prepare($query);

        if (!empty($array['whereValue'])) {
            $statementHandler->bindValue(":whereValue", $array['whereValue']);
        }

        if ($statementHandler->execute()) {
            return $statementHandler->fetchAll();
        }
    }

    /**
     *
     */
    public function disconnect()
    {
        $this->databaseHandler = null;
    }
}
