<?php

namespace Core\Db;

use Core\App;
use Core\Db\Exceptions\DbException;

/**
 * Class Db
 * @package Core\Db
 */
final class Db
{
    /**
     * @var
     */
    protected static $_instance; //TODO it is not PSR I mean naming protected property from _ Question: How should i name it? simply 'instance' - is reserved word
    /**
     * @var
     */
    protected static $DbHandler;

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
     * @throws \Core\Db\Exceptions\DbException
     */
    protected static function init()
    {
        $dbType = App::getConfig('db', 'dbType');
        $dbName = App::getConfig('db', 'dbName');
        $host = App::getConfig('db', 'host');
        $user = App::getConfig('db', 'user');
        $password = App::getConfig('db', 'password');


        $db = $dbType . ":dbname=" . $dbName . ";";
        $host = "host=" . $host;
        $dsn = $db . $host;

        try {
            self::$DbHandler = new \PDO($dsn, $user, $password);
            self::$DbHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new DbException("Failed to connect to '{$DbName}' Db", 403, $e);
        }
    }

    //TODO query builder wasn't a waste of time (maybe) because you have learnt something new while developing it but it all should be rewritten or aborted at all
    // What should I do with this?
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

        $statementHandler = self::$DbHandler->prepare($query);

        if (!empty($array['whereValue'])) {
            $statementHandler->bindValue(":whereValue", $array['whereValue']);
        }

        if ($statementHandler->execute()) {
            return $statementHandler->fetchAll(\PDO::FETCH_ASSOC);
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


        $statementHandler = self::$DbHandler->prepare($query);
        //$statementHandler->debugDumpParams();

        if ($statementHandler->execute($array['values'])) {
            return true;
        }

        return false;
    }
}
