<?php

/**
 * Class MySQLConnection
 *
 * Wrapper for the mysqli connect
 */
class MySQLConnection
{
    private static array $instances = [];
    private $conn;

    /**
     * MySQLConnection constructor.
     *
     * Creates a connection to the database and handles errors.
     */
    private function __construct()
    {
        $this->conn = mysqli_connect('localhost', 'admin', 'admin', 'cs341');
        mysqli_autocommit($this->conn, true);
        if (!$this->conn) {
            error_log('MYSQL CONN ERROR: ' . mysqli_connect_error());
        }
    }

    private function __clone()
    {
    }

    public static function getInstance(): MySQLConnection
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function query(string $query)
    {
        return mysqli_query($this->conn, $query);
    }

    public function getQueryResult()
    {
        return
    }
}