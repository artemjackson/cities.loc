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
    protected static $dbh = null;
    protected static $sth = null;
    protected static $query = null;

    /**
     *
     */
    protected function __construct()
    {
    }

    public static function prepare($query)
    {
        self::init();
        self::$query = $query;
        self::$sth = self::$dbh->prepare($query);
    }

    /**
     * @throws \Core\Db\Exceptions\DbException
     */
    protected static function init()
    {
        if (self::$dbh !== null) {
            return;
        }

        $dbType = App::getConfig('db', 'dbType');
        $dbName = App::getConfig('db', 'dbName');
        $host = App::getConfig('db', 'host');
        $user = App::getConfig('db', 'user');
        $password = App::getConfig('db', 'password');


        $db = $dbType . ":dbname=" . $dbName . ";";
        $host = "host=" . $host;
        $dsn = $db . $host;

        try {
            self::$dbh = new \PDO($dsn, $user, $password);
            self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new DbException("Failed to connect to '{$dbName}' Db", 403, $e);
        }
    }

    public static function execute(array $input_parameters = array())
    {
        self::init();
        $status = self::$sth->execute($input_parameters);
        return substr(self::$query,0,6) === 'SELECT' ? self::$sth->fetchAll(\PDO::FETCH_ASSOC) : $status;
    }
}
