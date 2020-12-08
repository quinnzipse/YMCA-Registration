<?php
include_once 'MembershipStatus.php';

class Staff extends User
{
    public string $ssn;
    public DateTime $dob;
    public string $middleInit;
    public DateTime $startDay;
    public int $salary;
    public string $phoneNumber;
    public string $address;

    /**
     * Given a User object, fill in the staff only fields.
     *
     * @param object $input_user
     */
    function fill(object $input_user)
    {
        $this->ssn = $input_user->SSN;
        $this->dob = date_create($input_user->DOB);
        $this->middleInit = $input_user->middleInitial;
        $this->startDay = date_create($input_user->StartDay);
        $this->salary = $input_user->Salary;
        $this->phoneNumber = $input_user->PhoneNumber;
        $this->address = $input_user->Address;
    }

    static function getStaff(int $page = 0): array
    {
        $pageLength = 20;
        $mysql = new MySQLConnection();
        $offset = $page * $pageLength;

        $sql = "SELECT * FROM Participants as p INNER JOIN Staff as s ON s.ID = p.ID WHERE MembershipStatus = " .
            MembershipStatus::STAFF . " LIMIT $offset, $pageLength;";
        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) {
            var_dump(mysqli_error($mysql->conn));
        }

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, User::userFactory($obj));
        }

        return $res;
    }

    static function search(string $search_val)
    {
        $mysql = new MySQLConnection();
        $val = metaphone($search_val);

        $sql = "SELECT * FROM Participants as p INNER JOIN Staff as s ON s.ID = p.ID WHERE MembershipStatus = " .
            MembershipStatus::STAFF . " AND p.indexed LIKE '%$val%';";

        $result = mysqli_query($mysql->conn, $sql);

        if ($result) {
            $output = array();

            while ($row = mysqli_fetch_object($result)) {
                array_push($output, User::userFactory($row));
            }

            return $output;
        } else {
            return mysqli_error($mysql->conn);
        }
    }

    function save(): bool
    {
        $mysql = new MySQLConnection();

        $dob = $this->dob->format('Y-m-d');
        $startDay = $this->startDay->format('Y-m-d');

        $sql = "INSERT INTO Staff VALUES $this->id, '$this->ssn', '$dob', '$this->middleInit', 
                         '$startDay', $this->salary, '$this->phoneNumber', '$this->address' ;";

        return mysqli_query($mysql->conn, $sql);
    }
}