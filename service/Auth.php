<?php
require_once "MySQLConnection.php";

/**
 * Class Auth
 *
 * Class for helpful authorization methods.
 */
class Auth
{
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
     * Wipes out the uuid cookie if there is one.
     * Redirects you to the login page with a referer cookie.
     */
    static function reauth()
    {
        // Revoke the clients UUID since it is invalid.
        setcookie('cs341_uuid', '', 1);

        // Remember where it came from.
        setcookie('login_referer', $_SERVER['REQUEST_URI'], 0, '/');

        // Send the to the login screen with a custom message.
        header('Location: /login.php?reauth=1');
    }

    /**
     * This will be executed at a set interval (~1 minute) as a cron task to check for stale UUIDs.
     * If so, it will deauthorize that UUID, forcing the end user to log in again.
     *
     * UUID is stale if it hasn't been updated in 20 minutes.
     */
    function validateSessions()
    {
        $sql = 'SELECT uuid FROM Authenticated_Users WHERE TIMESTAMPDIFF(minute, modified_at, CURRENT_TIME) > 20';
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
        $sql = "DELETE FROM Authenticated_Users WHERE uuid IN ('$uuids')";

        return mysqli_query($this->mysql->conn, $sql);
    }

    /**
     * Provided the UUID, get the user associated with it.
     *
     * @param string $uuid UUID of the user. Usually provided by the clients cookies.
     * @return object|false Associative array of user credentials. False on failure.
     */
    function getCurrentUser(string $uuid)
    {
        $sql = "SELECT * FROM 
              (SELECT userID, Email, FirstName, LastName, MembershipStatus 
              FROM Authenticated_Users INNER JOIN Participants 
                  ON ID = userID WHERE uuid = '$uuid') as User LEFT JOIN Staff ON userID = ID;";

        $result = mysqli_query($this->mysql->conn, $sql);

        if ($result && $result->num_rows == 1) {

            $user = mysqli_fetch_object($result);
            $user->isStaff = $user->MembershipStatus == 3 && !is_null($user->SSN);
            $this->refreshToken($uuid);

            return $user;
        }

        return false;
    }

    /**
     * Authorizes the current user based on the cs341_uuid cookie.
     *
     * If user is signed in, a user object will be returned.
     * Otherwise, the user will be redirected to sign-in.
     *
     * @return object Logged in user. Sends HTTP 400 error or failure.
     */
    function authorize(): object
    {
        $uuid = $_COOKIE['cs341_uuid'];
        // Helps mitigate SQL injection.
        if (!$uuid || strlen($uuid) != 36) {
            self::reauth();
            http_send_status(400);
            exit(400);
        } else {
            // Use the UUID to get the user.
            $user = $this->getCurrentUser($uuid);

            if (!$user) {
                self::reauth();
                http_send_status(400);
                exit(400);
            }
        }

        return $user;
    }

    /**
     * Authorizes the current user based on the cs341_uuid cookie.
     *
     * @return object|false
     */
    function authorizeStaff()
    {
        $uuid = $_COOKIE['cs341_uuid'];
        // Helps mitigate SQL injection.
        if (!$uuid || strlen($uuid) != 36) {
            return false;
        } else {
            // Use the UUID to get the user.
            $user = $this->getCurrentUser($uuid);

            if ($user && $user->isStaff) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Refreshes a uuid to prevent it from being wiped by cron task
     *
     * @see validateSessions()
     *
     * @param string $uuid what uuid should we refresh?
     * @return bool true on success, false on failure
     */
    function refreshToken(string $uuid): bool
    {
        setcookie("cs341_uuid", $uuid, array('expires' => time() + 1200, 'path' => '/', 'httponly' => true));
        $result = mysqli_query($this->mysql->conn, "UPDATE Authenticated_Users SET modified_at = CURRENT_TIME WHERE uuid = '$uuid'");

        return $result != false;
    }

    /**
     * Checks to see whether a user is logged in.
     *
     * This function will not redirect the user to login. To redirect a user if they aren't authorized
     *
     * @return bool|object|stdClass If the user is logged in, it will return the user, otherwise false.
     * @see authorize()
     */
    function isLoggedIn()
    {
        $uuid = $_COOKIE['cs341_uuid'] ?? null;

        if ($uuid && strlen($uuid) === 36) {

            $uuid = mysqli_real_escape_string($this->mysql->conn, $uuid);

            return $this->getCurrentUser($uuid);
        }

        return false;
    }

    /**
     * Logs the user out, wiping out their uuid cookie and revoking the uuid.
     *
     * @param string $uuid The UUID to revoke.
     * @return bool true on success, false on failure.
     */
    function logout(string $uuid): bool
    {
        // Erase the uuid client cookie.
        setcookie('cs341_uuid', '', 10);

        // Revoke UUID.
        return $this->revokeAccess(array($uuid));
    }
}