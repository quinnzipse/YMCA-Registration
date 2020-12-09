<?php

require_once 'MembershipStatus.php';
require_once 'Staff.php';

/**
 * Class User
 *
 * Abstraction of our the average User.
 */
class User
{

    public int $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public int $status;
    public string $indexed;
    public bool $isStaff;
    public bool $isInactive;

    public function __construct()
    {

    }

    public function disableUser(): bool
    {
        $mysql = new MySQLConnection();
        $this->isInactive = true;

        $sql = "UPDATE Participant_Programs SET status = 1 WHERE ParticipantID = $this->id";
        $result = mysqli_query($mysql->conn, $sql);

        if(!$result) return false;

        return $this->save();
    }

    public static function edit(int $id): bool
    {
        $user = User::get($id);
        $user->firstName = $_REQUEST['first'];
        $user->lastName = $_REQUEST['last'];
        $user->email = $_REQUEST['email'];
        $user->status = $_REQUEST['status'];

        return $user->save();
    }

    public static function get(int $id): User
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT * FROM Participants WHERE ID = $id";
        $result = mysqli_query($mysql->conn, $sql);

        $obj = mysqli_fetch_object($result);
        return User::userFactory($obj, false);
    }

    function isFree($classID)
    {
        // TODO: Check to see if the user is registered for another class during this time.
    }

    static function search(string $search_val)
    {
        $mysql = new MySQLConnection();
        $val = metaphone($search_val);

        $sql = "SELECT * FROM Participants WHERE indexed LIKE '%$val%'";

        $result = mysqli_query($mysql->conn, $sql);

        if ($result) {
            return $result->fetch_all();
        } else {
            return mysqli_error($mysql->conn);
        }
    }

    static function getUsers(int $page = 0): array
    {
        $pageLength = 20;
        $mysql = new MySQLConnection();
        $offset = $page * $pageLength;

        $sql = "SELECT * FROM Participants WHERE inactive = 0 LIMIT $offset, $pageLength;";
        $result = mysqli_query($mysql->conn, $sql);

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, User::userFactory($obj, false));
        }

        return $res;
    }

    static function getNonStaff(int $page = 0): array
    {
        $pageLength = 20;
        $mysql = new MySQLConnection();
        $offset = $page * $pageLength;

        $sql = "SELECT * FROM Participants WHERE MembershipStatus != 3 LIMIT $offset, $pageLength;";
        $result = mysqli_query($mysql->conn, $sql);

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, User::userFactory($obj, false));
        }

        return $res;
    }

    static function userFactory(object $input_user, bool $hasStaff): User
    {
        if ($input_user->MembershipStatus == MembershipStatus::STAFF && $hasStaff) {
            $user = new Staff();
            $user->fill($input_user);
        } else {
            $user = new User();
        }

        $user->id = $input_user->ID;
        $user->indexed = $input_user->indexed;
        $user->firstName = $input_user->FirstName;
        $user->lastName = $input_user->LastName;
        $user->status = $input_user->MembershipStatus;
        $user->email = $input_user->Email;
        $user->isInactive = $input_user->inactive == 1;

        return $user;
    }

    function makeStaff(): bool
    {
        $staff = new Staff();
        $staff->status = MembershipStatus::STAFF;
        $staff->id = $this->id;

        $staff->phoneNumber = $_POST['phone'];
        $staff->middleInit = $_POST['middle'];
        $staff->salary = $_POST['salary'];
        $staff->address = $_POST['address'];
        $staff->ssn = $_POST['ssn'];
        $staff->startDay = date_create($_POST['start_date']);
        $staff->dob = date_create($_POST['dob']);

        return $staff->save(Staff::exists($this->id));
    }

    function save(): bool
    {
        $mysql = new MySQLConnection();

        $inactive = ($this->isInactive ? 1 : 0);

        $sql = "UPDATE Participants SET Email = '$this->email', FirstName = '$this->firstName', 
                        LastName = '$this->lastName', inactive = $inactive, 
                        MembershipStatus = $this->status WHERE ID = $this->id";
        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) {
            echo mysqli_error($mysql->conn);
        }

        return $result;
    }
}