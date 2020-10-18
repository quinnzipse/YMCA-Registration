<?php
require 'MySQLConnection.php';
require 'Auth.php';

// Connect to the database!
$mysql = new MySQLConnection();

$cookieOptions = array('expires' => time() + 10, 'path' => '/login.php', 'httponly' => true);

// Collect and sanitize the user input.
$email = mysqli_real_escape_string($mysql->conn, $_REQUEST['username']);

// Check to see if this user already exists!
$sql = "SELECT * FROM Participants WHERE Email = '$email';";
$result = mysqli_query($mysql->conn, $sql);

if ($result) {
    if ($result->num_rows == 0) {
        // Bad Request, user does not exists!

        // Set the cookies to restore the info given.
        setcookie('email', $email, $cookieOptions);

        // Direct them back to form with failed message.
        header("Location: /login.php?failed=1");

        http_send_status(400);
        exit(400);

    } else {
        // Record exists, get the user.
        $user = $result->fetch_object();

        // Verify the password is correct.
        if (password_verify($_REQUEST['password'], $user->Password)) {
            // Create a UUID to associate with the user.
            $uuid = Auth::CreateUUID();
            $hashed_uuid = password_hash($uuid, PASSWORD_BCRYPT);

            // Put the hashed version in the database
            $sql = "INSERT INTO Authenticated_Users (userID, uuid) VALUES ('$user->ID', '$hashed_uuid');";
            $result = mysqli_query($mysql->conn, $sql);

            if (!$result) {
                // The uuid insert didn't work...
                $error = json_encode(mysqli_error($mysql->conn));\
                header("Location: /login.php?failed=3&reason=$error");

                http_send_status(500);
                exit(500);
            } else {
                // Give the uuid to the web browser as a cookie for 5 minutes.
                setcookie("cs341_uuid", $uuid, array('expires' => time() + 700, 'path' => '/', 'httponly' => true));
            }

        } else {
            // Set the cookies to restore the info given.
            setcookie('email', $email, $cookieOptions);

            // Direct them back to form with failed message.
            header("Location: /login.php?failed=1");

            http_send_status(400);
            exit(400);
        }
    }
} else {
    $error = json_encode(mysqli_error($mysql->conn));
    header("Location: /login.php?failed=3&reason=$error");
    http_send_status(500);
    exit(500);
}

header("Location: /?loggedIn=1");
exit(200);