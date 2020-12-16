<?php
//staff model
include_once 'MembershipStatus.php';
include_once 'User.php';

/**
 * Class Staff
 *
 * extends from User
 */
class Staff extends User
{
    //staff info variables
    public string $ssn;
    public DateTime $dob;
    public string $middleInit;
    public DateTime $startDay;
    public int $salary;
    public string $phoneNumber;
    public string $address;

    /**
     * edit the staff member
     *
     * @param int $id the id of the staff member
     * @return bool whether the edit worked or not
     */
    public static function editStaff(int $id): bool
    {
        $staff = self::get($id);
        $staff->phoneNumber = $_POST['phone'];
        $staff->middleInit = $_POST['middle'];
        $staff->salary = $_POST['salary'];
        $staff->address = $_POST['address'];
        $staff->ssn = $_POST['ssn'];
        $staff->startDay = date_create($_POST['start_date']);
        $staff->dob = date_create($_POST['dob']);

        return $staff->save(false);
    }

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

    /**
     * get the array of staff members
     *
     * @param int $page the amount of space on the page
     * @return array    an array of the staff members
     */
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
            array_push($res, User::userFactory($obj, true));
        }

        return $res;
    }

    /**
     * search for staff by a particular value associated with that staff member
     *
     * @param string $search_val
     * @return array|mixed|string
     */
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
                array_push($output, User::userFactory($row, true));
            }

            return $output;
        } else {
            return mysqli_error($mysql->conn);
        }
    }

    /**
     * save a staff member after creation
     *
     * @param bool $new used for creating member
     * @return bool whether the staff member was saved in the database
     */
    function save($new = true): bool
    {
        $mysql = new MySQLConnection();

        $dob = $this->dob->format('Y-m-d');
        $startDay = $this->startDay->format('Y-m-d');

        if ($new) {

            $sql = "INSERT INTO Staff VALUES ($this->id, '$this->ssn', '$dob', '$this->middleInit', 
                         '$startDay', $this->salary, '$this->phoneNumber', '$this->address');";
            $result = mysqli_query($mysql->conn, $sql);

            if (!$result) {
                echo mysqli_error($mysql->conn);
                return false;
            }

            $sql = "UPDATE Participants SET MembershipStatus = 3 WHERE ID = $this->id";
            $result = mysqli_query($mysql->conn, $sql);

        } else {
            $sql = "UPDATE Staff SET SSN = '$this->ssn', DOB = '$dob', middleInitial = '$this->middleInit', 
                         StartDay = '$startDay', Salary = $this->salary, PhoneNumber = '$this->phoneNumber',
                         Address = '$this->address' WHERE ID = $this->id;";
            $result = mysqli_query($mysql->conn, $sql);

            if (!$result) {
                echo mysqli_error($mysql->conn);
                return false;
            }

            $sql = "UPDATE Participants SET MembershipStatus = $this->status WHERE ID = $this->id";
            $result = mysqli_query($mysql->conn, $sql);
        }

        if (!$result) {
            echo mysqli_error($mysql->conn);
        }

        return $result;
    }

    /**
     * Revokes Staff Access but retains the staff information.
     *
     * @return bool true on success, false on failure.
     */
    public function revokeStaffAccess(): bool
    {
        $this->isStaff = false;
        $this->status = MembershipStatus::NONMEMBER;

        return $this->save(false);
    }

    /**
     * get a staff member based on the staff member id
     *
     * @param int $id   id of staff member
     * @return Staff    returns the staff member as a staff type
     */
    public static function get(int $id): Staff
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT * FROM Participants as p INNER JOIN Staff as s ON s.ID = p.ID WHERE p.ID = $id AND MembershipStatus = " . MembershipStatus::STAFF;
        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) {
            echo mysqli_error($mysql->conn);
        }

        $obj = mysqli_fetch_object($result);

        return Staff::staffFactory($obj);
    }

    /**
     * check whether a staff member exists based on the id
     *
     * @param int $id id of the staff member
     * @return bool whether the staff member exists
     */
    static function exists(int $id): bool
    {
        $mysql = new MySQLConnection();

        $sql = "SELECT * FROM Participants as p INNER JOIN Staff as s ON s.ID = p.ID WHERE p.ID = $id AND MembershipStatus = " . MembershipStatus::STAFF;
        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) {
            echo mysqli_error($mysql->conn);
        }

        return $result->num_rows > 0;
    }

    /**
     * creates a staff member object
     *
     * @param object $input_user the user object
     * @return Staff    returns the user as a staff member object
     */
    static function staffFactory(object $input_user): Staff
    {
        $user = new Staff();
        $user->fill($input_user);
        $user->id = $input_user->ID;
        $user->indexed = $input_user->indexed;
        $user->firstName = $input_user->FirstName;
        $user->lastName = $input_user->LastName;
        $user->status = $input_user->MembershipStatus;
        $user->email = $input_user->Email;

        return $user;
    }

}