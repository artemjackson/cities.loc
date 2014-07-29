<?php

namespace Core\Database;

use Core\Application;
use Core\Database\Exceptions\DatabaseException;

//TODO rename to Db because Database is too long and you need all the time write Database::blabla
/**
 * Class Database
 * @package Core\Database
 */
final class Database
{
    /**
     * @var
     */
    protected static $_instance; //TODO it is not PSR I mean naming protected property from _
    /**
     * @var
     */
    protected static $databaseHandler;

    /**
     *
     */
    protected function __construct()
    {
    }

    /**
     * @return static
     */
    public static function getConnection()
    {
        if (is_null(self::$_instance)) {
            self::init();
            self::$_instance = new static;
        }
        return self::$_instance;
    }

    /**
     * @throws \Core\Database\Exceptions\DatabaseException
     */
    protected static function init()
    {
        $databaseType = Application::getConfiguration('database', 'databaseType');
        $databaseName = Application::getConfiguration('database', 'databaseName');
        $host = Application::getConfiguration('database', 'host');
        $user = Application::getConfiguration('database', 'user');
        $password = Application::getConfiguration('database', 'password');


        $db = $databaseType . ":dbname=" . $databaseName . ";";
        $host = "host=" . $host;
        $dsn = $db . $host;

        try {
            self::$databaseHandler = new \PDO($dsn, $user, $password);
            self::$databaseHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new DatabaseException("Failed to connect to '{$databaseName}' database", 403, $e);
        }
    }

    //TODO query builder wasn't a waste of time (maybe) because you have learnt something new while developing it but it all should be rewritten or aborted at all
    /**
     * @param array $array
     * @return mixed
     */
    public function get(array $array = array())
    {
        $query = '';

        if (!empty($array['select'])) {
            $query .= "SELECT " . $array['select'];
        }

        if (!empty($array['from'])) {
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

        $statementHandler = self::$databaseHandler->prepare($query);

        if (!empty($array['whereValue'])) {
            $statementHandler->bindValue(":whereValue", $array['whereValue']);
        }

        if ($statementHandler->execute()) {
            return $statementHandler->fetchAll();
        }
    }

    public function add(array $array = array())
    {
        $query = '';

        if (!empty($array['insertInto'])) {
            $query .= "INSERT INTO " . $array['insertInto'];
        }

        if (!empty($array['columns'])) {
            $query .= " (" . implode(", ", $array['columns']) . ")";
        }

        if (!empty($array['values'])) {
            $query .= " VALUES ";
        }

        $query .= "(";

        for ($i = 0, $size = count($array['values']) - 1; $i < $size; $i++) {
            $query .= "?, ";
        }

        $query .= "?)";


        $statementHandler = self::$databaseHandler->prepare($query);
        //$statementHandler->debugDumpParams();

        if ($statementHandler->execute($array['values'])) {
            return true;
        }

        return false;
    }
}
