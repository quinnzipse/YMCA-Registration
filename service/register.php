<?php
require 'MySQLConnection.php';

// Connect to the database!
$mysql = new MySQLConnection();

$cookieOptions = array('expires' => time() + 10, 'path' => '/register.php', 'httponly' => true);

// Collect and sanitize the user input.
$email = mysqli_real_escape_string($mysql->conn, $_REQUEST['username']);
$firstName = mysqli_real_escape_string($mysql->conn, $_REQUEST['firstName']);
$lastName = mysqli_real_escape_string($mysql->conn, $_REQUEST['lastName']);
$index = metaphone($firstName) . " " . metaphone($lastName) . " " . metaphone($email);

// HASH THE PASSWORD!
$hashedPassword = password_hash($_REQUEST['password'], PASSWORD_BCRYPT);

// Check to see if this user already exists!
$sql = "SELECT * FROM Participants WHERE Email = '$email';";
$result = mysqli_query($mysql->conn, $sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Bad Request, user exists!

        // Set the cookies to restore the info given.
        setcookie('firstName', $firstName, $cookieOptions);
        setcookie('lastName', $lastName, $cookieOptions);
        setcookie('email', $email, $cookieOptions);

        // Direct them back to form with failed message.
        header("Location: /register.php?failed=1");

        http_send_status(400);
        exit(400);

    } else {
        // Record Doesn't exist, we will have to add it!
        $sql = "INSERT INTO Participants (Email, FirstName, LastName, Password, indexed) VALUES 
                ('$email', '$firstName', '$lastName', '$hashedPassword', '$index');";
        $result = mysqli_query($mysql->conn, $sql);

        if (!$result) {
            // Insert Failed.

            // Set the cookies to restore the info given.
            setcookie('firstName', $firstName, $cookieOptions);
            setcookie('lastName', $lastName, $cookieOptions);
            setcookie('email', $email, $cookieOptions);

            // Direct them back to form with an error code.
            $error = json_encode(mysqli_error($mysql->conn));
            header("Location: /register.php?failed=2&reason=$error");
            http_send_status(500);
            exit(500);

        }
    }
} else {
    $error = json_encode(mysqli_error($mysql->conn));
    header("Location: /register.php?failed=3&reason=$error");
    http_send_status(500);
    exit(500);
}

header("Location: /login.php?registered=1");
exit(200);