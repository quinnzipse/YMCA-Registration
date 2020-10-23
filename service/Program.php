<?php
require_once "MySQLConnection.php";

class Program {
    /**
     * The MySQLConnection to use.
     * For more info @see MySQLConnection
     *
     * @var MySQLConnection mysql
     */
    private MySQLConnection $mysql;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->mysql = new MySQLConnection();
    }

    function getPrograms() {
		$sql = "SELECT * FROM Programs LIMIT 20;";
		$result = mysqli_query($this->mysql->conn, $sql);
		
		$res = array();
		
		while($obj = mysqli_fetch_object($result)) {
			array_push($res, $obj);
		}

		return $res;
    }
}
