<?php

use Cassandra\Date;

require_once "MySQLConnection.php";

class Program
{
    /**
     * The MySQLConnection to use.
     * For more info @see MySQLConnection
     *
     * @var MySQLConnection mysql
     */
    private MySQLConnection $mysql;

    private int $id;
    public string $name;
    public string $shortDesc;
    public string $descFile;
    public int $capacity;
    public int $memberFee;
    public int $nonMemberFee;
    public string $location;
    public Date $startDate;
    public Date $endDate;
    public Date $startTime;
    public Date $endTime;
    private int $dayOfWeek;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->mysql = new MySQLConnection();
    }

    function getPrograms()
    {
        // TODO: add pagination to this.
        $sql = "SELECT * FROM Programs LIMIT 20;";
        $result = mysqli_query($this->mysql->conn, $sql);

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, $obj);
        }

        return $res;
    }

    // TODO: Create a function that creates a new program.

    function isConflicting($classID)
    {
        // TODO: Create a function that checks to see if a class conflicts with another class.
    }

    // TODO: Create a function that saves all the datamembers back to the database.
    function save() : bool
    {
        $sql = "UPDATE Programs SET Name = $this->name, ShortDesc = $this->shortDesc, DescFile = $this->descFile, 
                    Capacity = $this->capacity, MemberFee = $this->memberFee, NonMemberFee = $this->nonMemberFee,
                    Location = $this->location, start_date = $this->startDate, end_date = $this->endDate, 
                    start_time = $this->startTime, end_time = $this->endTime, day_of_week = $this->dayOfWeek 
                    WHERE ID = $this->id";

        return mysqli_query($this->mysql->conn, $sql);
    }

    function get(int $id) : bool
    {
        $sql = "SELECT * FROM Participants WHERE ID = $id";

        return mysqli_query($this->mysql->conn, $sql);
    }
}
