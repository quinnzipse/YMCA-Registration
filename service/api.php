<?php
set_include_path('/var/www/html');
require_once 'authorize.php';
require_once 'models/Program.php';
require_once 'models/User.php';

//echo " -- GET -- ";
//var_dump($_GET);
//echo " -- POST -- ";
//var_dump($_POST);

// ANYTHING in this file will require the user to be logged in.
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'createProgram':
        $program = new Program();
        if (!$program->createProgram()) {
            header("Location: /staff/addProgram.php?failed=1");
            http_send_status(400);
            exit(400);
        }
        header("Location: /staff/?programCreated=1");
        break;
    case 'getRoster':
        $program = Program::get($_GET['programID'] ?? -1);

        echo json_encode($program->getRoster() ?? '');
        exit(200);
    case 'register':
        $programID = $_GET['programID'] ?? '';
        $mysql = new MySQLConnection();
        $a = new Auth();
        $u = $a->getCurrentUser($_COOKIE['cs341_uuid']);
        $sql = "INSERT INTO Participant_Programs (ParticipantID, ProgramID) VALUES ($u->userID, $programID);";
        mysqli_query($mysql->conn, $sql);
        header("Location: /program");
        break;
    default:
        // bad request.
        http_send_status(400);
        exit(400);
}

//if (isset($_GET['debug'])) {

//}

