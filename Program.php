<?php
require_once "../service/MySQLConnection.php";

class Program
{
    private int $id;
    public string $name;
    public string $shortDesc;
    public string $descFile;
    public int $capacity;
    public int $memberFee;
    public int $nonMemberFee;
    public string $location;
    public DateTime $startDate;
    public DateTime $endDate;
    public DateTime $startTime;
    public DateTime $endTime;
    private int $dayOfWeek;

    public function __construct()
    {
    }

    static function getPrograms(int $page = 0): array
    {
        $pageLength = 20;
        $mysql = new MySQLConnection();
        $offset = $page * $pageLengthj

        $sql = "SELECT * FROM Programs LIMIT $offset, $pageLength;";
        $result = mysqli_query($mysql->conn, $sql);

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, Program::programFactory($obj));
        }

        return $res;
    }

    // TODO: Create a function that creates a new program.

    function isConflicting(Program $other): bool
    {
        if ($this->dayOfWeek & $other->dayOfWeek == 0) return false;
        if ($this->startDate > $other->endDate && $this->endDate < $other->startDate) return false;
        if ($this->startTime > $other->startTime && $this->startTime < $other->endTime) return true;
        if ($other->startTime > $this->startTime && $other->startTime < $this->endTime) return true;
        return false;
    }

    function save(): bool
    {
        $mysql = new MySQLConnection();
        $sql = "SELECT COUNT(*) AS C FROM Programs WHERE ID = $this->id";

        $result = mysqli_query($mysql->conn, $sql)->fetch_array();

        if ($result['C'] == 1) {
            $sql = "UPDATE Programs SET Name = $this->name, ShortDesc = $this->shortDesc, DescFile = $this->descFile, 
                    Capacity = $this->capacity, MemberFee = $this->memberFee, NonMemberFee = $this->nonMemberFee,
                    Location = $this->location, start_date = $this->startDate, end_date = $this->endDate, 
                    start_time = $this->startTime, end_time = $this->endTime, day_of_week = $this->dayOfWeek 
                    WHERE ID = $this->id";
        } else {
            $sql = "INSERT INTO Programs (NAME, DESCFILE, ShortDesc, CAPACITY, MEMBERFEE, NONMEMBERFEE, LOCATION, START_DATE, 
                      END_DATE, START_TIME, END_TIME, DAY_OF_WEEK) VALUES ($this->name, $this->descFile, $this->shortDesc,
                      $this->capacity, $this->memberFee, $this->nonMemberFee, $this->location, $this->startDate, 
                      $this->endDate, $this->startTime, $this->endTime, $this->dayOfWeek)";
        }

        return mysqli_query($mysql->conn, $sql);
    }

    static function programFactory(object $input_program): Program
    {
        $program = new Program();
        $program->id = $input_program->ID;
        $program->startDate = date_create($input_program->start_date);
        $program->endDate = date_create($input_program->end_date);
        $program->startTime = date_create($input_program->start_time);
        $program->endTime = date_create($input_program->end_time);
        $program->dayOfWeek = $input_program->day_of_week;
        $program->name = $input_program->Name;
        $program->location = $input_program->Location;
        $program->descFile = $input_program->DescFile;
        $program->shortDesc = $input_program->ShortDesc;
        $program->capacity = $input_program->Capacity;
        $program->memberFee = $input_program->MemberFee;
        $program->nonMemberFee = $input_program->NonMemberFee;

        return $program;
    }
    static function getParticipantProgram(int $user_id): array
	{

		$mysql = new MySQLConnection();

		$sql = "SELECT ProgramID FROM Participant_Programs WHERE ParticipantID='$user_id';";

		$programs = mysqli_query($mysql->conn, $sql)->fetch_array();
		$result = array();	
		
		foreach($prog_id as &$programs) {
			array_push($result, get($prog_id));	
		}
		
		return $result;
		
	}
    static function get(int $id): Program
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT * FROM Participants WHERE ID = $id";

        $result = mysqli_query($mysql->conn, $sql)->fetch_object();

        return Program::programFactory($result);
    }

    function getDaysOfWeek(): array
    {
        $daysOfTheWeek = array();

        if ($this->dayOfWeek & 1) array_push($daysOfTheWeek, 'Sunday');
        if ($this->dayOfWeek >> 1 & 1) array_push($daysOfTheWeek, 'Monday');
        if ($this->dayOfWeek >> 2 & 1) array_push($daysOfTheWeek, 'Tuesday');
        if ($this->dayOfWeek >> 3 & 1) array_push($daysOfTheWeek, 'Wednesday');
        if ($this->dayOfWeek >> 4 & 1) array_push($daysOfTheWeek, 'Thursday');
        if ($this->dayOfWeek >> 5 & 1) array_push($daysOfTheWeek, 'Friday');
        if ($this->dayOfWeek >> 6 & 1) array_push($daysOfTheWeek, 'Saturday');

        return $daysOfTheWeek;
    }

    function setDaysOfWeek(array $days)
    {
        $this->dayOfWeek = 0;
        foreach ($days as $day) {
            switch (strtolower($day)) {
                case "sunday":
                    $this->dayOfWeek |= 1;
                    break;
                case "monday":
                    $this->dayOfWeek |= 2;
                    break;
                case "tuesday":
                    $this->dayOfWeek |= 4;
                    break;
                case "wednesday":
                    $this->dayOfWeek |= 8;
                    break;
                case "thursday":
                    $this->dayOfWeek |= 16;
                    break;
                case "friday":
                    $this->dayOfWeek |= 32;
                    break;
                case "saturday":
                    $this->dayOfWeek |= 64;
            }
        }
    }

    function createProgram()
    {

    }
}
