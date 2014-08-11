<?php

namespace Core\Db;

use Core\App;
use Core\Db\Exceptions\DbException;
use Core\Loggers\FileLogger\FileLogger;

/**
 * Class Db
 * @package Core\Db
 */
final class Db
{
    /**
     * @var
     */
    protected static $dbh = null;
    /**
     * @var null
     */
    protected static $sth = null;
    /**
     * @var null
     */
    protected static $query = null;
    protected static $logger = null;

    /**
     * @param $query
     */
    public static function prepare($query)
    {
        self::init();
        self::$logger->log('Query preparation: ' . $query);
        self::$query = $query;
        self::$sth = self::$dbh->prepare($query);
    }

    /**
     * @throws \Core\Db\Exceptions\DbException
     */
    protected static function init()
    {
        if (self::$logger == null) {
            self::$logger = new FileLogger('db_actions.log');
        }

        if (self::$dbh !== null) {
            return;
        }

        $dbConfig = App::getConfig('db');
        $dbType = isset($dbConfig['dbType']) ? $dbConfig['dbType'] : null;
        $dbName = isset($dbConfig['dbName']) ? $dbConfig['dbName'] : null;
        $host = isset($dbConfig['host']) ? $dbConfig['host'] : null;
        $user = isset($dbConfig['user']) ? $dbConfig['user'] : null;
        $password = isset($dbConfig['password']) ? $dbConfig['password'] : null;


        $db = $dbType . ":dbname=" . $dbName . ";";
        $host = "host=" . $host;
        $dsn = $db . $host;

        try {
            self::$dbh = new \PDO($dsn, $user, $password);
            self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            self::$logger->error("Can not connect to db : '$dbName' please check config file");
            throw new DbException("Failed to connect to '$dbName' db", 403, $e);
        }
    }

    /**
     * @param array $input_parameters
     * @return mixed
     */
    public static function execute(array $input_parameters = array())
    {
        self::init();
        self::$logger->begin();
        if ($input_parameters) {
            self::$logger->log("Query execution with params:");
            self::$logger->log($input_parameters);
        }

        self::$sth->execute($input_parameters);
        $status = self::$sth->rowCount();
        if ($status) {
            self::$logger->log("Query execution finished successfully");
        } else {
            self::$logger->error("Query execution failed");
        }
        self::$logger->commit();
        return substr(self::$query, 0, 6) === 'SELECT' ? self::$sth->fetchAll(
            \PDO::FETCH_ASSOC
        ) : $status; //TODO refactor it
    }
}
