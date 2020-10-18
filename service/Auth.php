<?php
require_once "MySQLConnection.php";

class Auth
{

    private $mysql;

    public function __construct()
    {
        $this->mysql = new MySQLConnection();
    }

    /**
     * Stolen straight from phpdoc :)
     * Find it here: https://www.php.net/manual/en/function.uniqid.php
     *
     * Creates a VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID) version 4.
     * @return string UUID
     **/
    static function CreateUUID(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    /**
     * This will be executed at a set interval (~1 minute) as a cron task to check for stale UUIDs.
     * If so, it will deauthorize that UUID, forcing the end user to log in again.
     *
     * UUID is stale if it hasn't been updated in 10 minutes.
     */
    function validateSessions()
    {
        $sql = 'SELECT uuid FROM Authenticated_Users WHERE TIMESTAMPDIFF(minute, modified_at, CURRENT_TIME) > 10';
        $result = mysqli_query($this->mysql->conn, $sql);

        if ($result) {
            if ($result->num_rows > 0) {
                // Query for stale UUIDs
                $uuids = mysqli_fetch_all($result);

                // Pull all the uuids out of the array of arrays. (Check out mysqli_fetch_all for more detail).
                $uuids = array_column($uuids, 0);

                // Revoke the uuids returned.
                if (!$this->revokeAccess($uuids)) {
                    // Log the error and echo it so cron will notify us.
                    echo "Error revoking access! " . __METHOD__;
                    error_log(__METHOD__ . " Error revoking access!");
                }
            }
        } else {
            // Log the error and echo it so cron will notify us.
            echo "ERROR WITH " . __METHOD__ . " " . mysqli_error($this->mysql->conn);
            error_log(mysqli_error($this->mysql->conn));
        }
    }

    /**
     * Revokes a list of uuids supplied.
     *
     * @param array $uuids an array of uuids to revoke.
     * @return bool true on success, false on failure.
     */
    function revokeAccess(array $uuids): bool
    {
        $uuids = join("', '", $uuids);
        var_dump($uuids);
        $sql = "DELETE FROM Authenticated_Users WHERE uuid IN ('$uuids')";

        return mysqli_query($this->mysql->conn, $sql);
    }

    /**
     * Provided the UUID, get the user associated with it.
     *
     * @param string $uuid UUID of the user. Usually provided by the clients cookies.
     * @return object|false Associative array of user credentials. False on failure.
     */
    function getCurrentUser(string $uuid): object
    {
        $sql = "SELECT * FROM Participants WHERE ID = (SELECT userID FROM Authenticated_Users WHERE uuid = '$uuid')";
        $result = mysqli_query($this->mysql->conn, $sql);

        if ($result && $result->num_rows == 1) {
            return mysqli_fetch_object($result);
        }

        return false;
    }
}