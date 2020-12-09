<?php
require_once("service/MySQLConnection.php");

class Program
{
    public int $id = 0;
    public string $name;
    public string $shortDesc;
    public string $descFile = '/tmp/null';
    public int $capacity;
    public int $memberFee;
    public int $nonMemberFee;
    public string $indexed;
    public bool $inactive;
    public string $location;
    public DateTime $startDate;
    public DateTime $endDate;
    public DateTime $startTime;
    public DateTime $endTime;
    private int $dayOfWeek;
    public array $days;

    public function __construct()
    {
    }

    /**
     * returns how many people are registered for program.
     */
    function programCount(): int
    {
        $mysql = new MySQLConnection();
        $sql = "SELECT COUNT(*) AS people FROM Participant_Programs WHERE ProgramID = $this->id AND status = 0";

        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) {
            mysqli_error($mysql->conn);
        }

        return mysqli_fetch_assoc($result)['people'];
    }

    static function getPrograms(int $page = 0): array
    {
        $pageLength = 20;
        $mysql = new MySQLConnection();
        $offset = $page * $pageLength;

        $sql = "SELECT * FROM Programs LIMIT $offset, $pageLength;";
        $result = mysqli_query($mysql->conn, $sql);

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, Program::programFactory($obj));
        }

        return $res;
    }

    function disableProgram(): bool
    {
        $this->inactive = true;
        return $this->save();
    }

    function isConflicting(Program $other): bool
    {
        if ($this->inactive || $other->inactive) return false;

        if (($this->dayOfWeek & $other->dayOfWeek) === 0) {
            return false;
        }
        if ($this->startDate > $other->endDate || $this->endDate < $other->startDate) {
            return false;
        }
        if ($this->startTime >= $other->startTime && $this->startTime <= $other->endTime) {
            return true;
        }
        if ($other->startTime >= $this->startTime && $other->startTime <= $this->endTime) {
            return true;
        }

        return false;
    }

    public static function getProgramsByUser(int $id): array
    {
        $mysql = new MySQLConnection();
        $sql = "SELECT * FROM Participant_Programs JOIN Programs ON ProgramID = ID WHERE ParticipantID = $id";

        $result = mysqli_query($mysql->conn, $sql);
        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, Program::programFactory($obj));
        }

        return $res;
    }

    function save(): bool
    {
        $mysql = new MySQLConnection();
        $sql = "SELECT COUNT(*) AS C FROM Programs WHERE ID = $this->id";

        $result = mysqli_query($mysql->conn, $sql)->fetch_array();

        $sTime = $this->startTime->format('G:i');
        $eTime = $this->endTime->format('G:i');
        $sDate = $this->startDate->format('Y-m-d');
        $eDate = $this->endDate->format('Y-m-d');

        if ($result['C'] == 1) {
            $inactive = $this->inactive ? 1 : 0;
            $sql = "UPDATE Programs SET Name = '$this->name', ShortDesc = '$this->shortDesc', DescFile = '$this->descFile', 
                    Capacity = $this->capacity, MemberFee = $this->memberFee, NonMemberFee = $this->nonMemberFee,
                    Location = '$this->location', start_date = '$sDate', end_date = '$eDate', 
                    start_time = '$sTime', end_time = '$eTime', day_of_week = $this->dayOfWeek, indexed = '$this->indexed', inactive = $inactive
                    WHERE ID = $this->id";
        } else {
            $sql = "INSERT INTO Programs (NAME, DESCFILE, ShortDesc, CAPACITY, MEMBERFEE, NONMEMBERFEE, LOCATION, START_DATE, 
                      END_DATE, START_TIME, END_TIME, DAY_OF_WEEK, indexed, inactive) VALUES ('$this->name', '$this->descFile', '$this->shortDesc',
                      $this->capacity, $this->memberFee, $this->nonMemberFee, '$this->location', '$sDate', 
                      '$eDate', '$sTime', '$eTime', $this->dayOfWeek, '$this->indexed', 0)";
        }

        $result = mysqli_query($mysql->conn, $sql);
        var_dump(mysqli_error($mysql->conn));
        return $result;
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
        $program->indexed = $input_program->indexed;
        $program->inactive = $input_program->inactive == 1;
        $program->days = $program->getDaysOfWeek();

        return $program;
    }

    static function getParticipantProgram(int $user, int $status = 0): array
    {
        $result = array();

        $mysql = new MySQLConnection();

        $sql = "SELECT ProgramID FROM Participant_Programs WHERE ParticipantID='$user' AND status='$status';";

        $programs = mysqli_query($mysql->conn, $sql)->fetch_all(MYSQLI_NUM);
        $prog = null;
        foreach ($programs as $prog) {
            array_push($result, Program::get(array_pop($prog)));
        }
        return $result;
    }

    static function get(int $id): Program
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT * FROM Programs WHERE ID = $id";

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

    static function search(string $search_val)
    {
        $mysql = new MySQLConnection();
        $val = metaphone($search_val);

        $sql = "SELECT * FROM Programs WHERE indexed LIKE '%$val%'";

        $result = mysqli_query($mysql->conn, $sql);

        if ($result) {
            $output = array();

            while ($row = mysqli_fetch_object($result)) {
                array_push($output, Program::programFactory($row));
            }

            return $output;
        } else {
            return mysqli_error($mysql->conn);
        }
    }

    function createProgram()
    {
        $this->name = $_REQUEST['name'];
        $this->location = $_REQUEST['location'];
        $this->capacity = $_REQUEST['capacity'];
        try {
            $this->endDate = new DateTime($_REQUEST['end_date']);
            $this->startDate = new DateTime($_REQUEST['start_date']);
            $this->startTime = new DateTime($_REQUEST['start_time']);
            $this->endTime = new DateTime($_REQUEST['end_time']);
        } catch (Exception $e) {
            return "Exception";
        }
        $this->memberFee = $_REQUEST['mem_price'];
        $this->nonMemberFee = $_REQUEST['non_mem_price'];
        $this->shortDesc = ($_REQUEST['description'] ?? '');

        $this->dayOfWeek = 0;
        foreach ($_REQUEST['DayOfWeek'] as $item) {
            $this->dayOfWeek |= $item;
        }

        $this->indexed = metaphone($this->name) . " " . metaphone($this->location);

        return $this->save();
    }

    static function editProgram(int $id = -1): bool
    {
        if ($id != -1) {
            echo 'getting';
            $program = Program::get($id);
            return $program->createProgram();
        } else {
            echo "Program ID was bad";
            return false;
        }
    }


    public function getRoster()
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT LastName, FirstName, ParticipantID, Email, MembershipStatus FROM Participant_Programs LEFT JOIN Participants AS P ON ParticipantID = P.ID WHERE ProgramID = $this->id AND status != 1";

        return mysqli_query($mysql->conn, $sql)->fetch_all();
    }
}
