<?php

/**
 * Class MySQLConnection
 *
 * Wrapper for the mysqli connect
 */
class MySQLConnection
{
    public $conn;

    /**
     * MySQLConnection constructor.
     *
     * Creates a connection to the database and handles errors.
     */
    public function __construct()
    {
        $this->conn = mysqli_connect('localhost', 'admin', 'admin', 'cs341');
        mysqli_autocommit($this->conn, true);
        if (!$this->conn) {
            error_log('MYSQL CONN ERROR: ' . mysqli_connect_error());
        }
    }

    public function __deconstruct()
    {
        $this->conn->close();
    }
}