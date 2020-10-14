<?php
require_once 'MySQLConnection.php';

$mysql = new MySQLConnection();

var_dump($mysql->conn);