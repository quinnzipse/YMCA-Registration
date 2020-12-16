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
    //user info
    public int $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public int $status;
    public string $indexed;
    public bool $isStaff;
    public bool $isInactive;

    /**
     * User constructor.
     */
    public function __construct()
    {

    }

    /**
     * disable a user
     *
     * @return bool return whether the user was disabled
     */
    public function disableUser(): bool
    {
        $mysql = new MySQLConnection();
        $this->isInactive = true;

        $sql = "UPDATE Participant_Programs SET status = 1 WHERE ParticipantID = $this->id";
        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) return false;

        return $this->save();
    }

    /**
     * edit a user
     *
     * @param int $id   user id to be edited
     * @return bool     whether the edit worked
     */
    public static function edit(int $id): bool
    {
        $user = User::get($id);
        $user->firstName = $_REQUEST['first'];
        $user->lastName = $_REQUEST['last'];
        $user->email = $_REQUEST['email'];
        $user->status = $_REQUEST['status'];

        return $user->save();
    }

    /**
     * reenable a user account
     *
     * @return bool returns whether the account was reenabled
     */
    function enable(): bool
    {
        $mysql = new MySQLConnection();
        $sql = "UPDATE Participants SET inactive = 0 WHERE ID = $this->id";

        return mysqli_query($mysql->conn, $sql);
    }

    /**
     * get a user object based on the user id
     *
     * @param int $id the id of the user to be got
     * @return User the user object of that user
     */
    public static function get(int $id): User
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT * FROM Participants WHERE ID = $id";
        $result = mysqli_query($mysql->conn, $sql);

        $obj = mysqli_fetch_object($result);
        return User::userFactory($obj, false);
    }

    /**
     * search for a user based on an associated value
     *
     * @param string $search_val value to be searched
     * @return mixed|string search results
     */
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

    /**
     * get a list of users
     *
     * @param int $page value for computing
     * @return array the array of users
     */
    static function getUsers(int $page = 0): array
    {
        $pageLength = 20;
        $mysql = new MySQLConnection();
        $offset = $page * $pageLength;

        $sql = "SELECT * FROM Participants LIMIT $offset, $pageLength;";
        $result = mysqli_query($mysql->conn, $sql);

        $res = array();

        while ($obj = mysqli_fetch_object($result)) {
            array_push($res, User::userFactory($obj, false));
        }

        return $res;
    }

    /**
     * get non staff members
     *
     * @param int $page value for computing
     * @return array array of non staff users
     */
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

    /**
     * turn a user from a general object to a user object
     *
     * @param object $input_user the user to be converted
     * @param bool $hasStaff whether the user is staff
     * @return User user object
     */
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

    /**
     * make the user a staff member
     *
     * @return bool whether the user is now a staff member
     */
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

    /**
     * save the user
     *
     * @return bool whether the user was saved in the database
     */
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