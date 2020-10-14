<?php


class MySQLConnection
{
    public $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect('localhost', 'admin', 'admin', 'cs341');
        if(!$this->conn){
            error_log('MYSQL CONN ERROR: ' . mysqli_connect_error());
        }
    }
}