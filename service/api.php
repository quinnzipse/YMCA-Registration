<?php
set_include_path('/var/www/html');
require_once 'authorize.php';
require_once 'models/Program.php';
require_once 'models/User.php';
require_once 'models/Staff.php';

//echo " -- GET -- ";
//var_dump($_GET);
//echo " -- POST -- ";
//var_dump($_POST);

// ANYTHING in this file will require the user to be logged in.
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'addStaff':
        echo 'addStaff';
        if (isset($_POST['id'])) {
            echo 'hasID';
            // Consider reworking this to only return one element...
            $user = User::get($_POST['id']);
            var_dump($user);
            if (!$user->makeStaff()) {
                header("Location: /admin/staff/addStaff.php?failed=1");
                exit(400);
            }
            header("Location: /admin/staff/?staffAdded=1");
        }
        break;
    case 'createProgram':
        $program = new Program();
        if (!$program->createProgram()) {
            header("Location: /admin/programs/addProgram.php?failed=1");
            http_send_status(400);
            exit(400);
        }
        header("Location: /admin/programs/?programCreated=1");
        break;
    case 'editProgram':
        if (!Program::editProgram((int)$_POST['id'])) {
            header("Location: /admin/programs/editProgram.php?p=" . $_POST['id'] . "&failed=1");
            http_send_status(400);
            exit(400);
        }
        header("Location: /admin/programs/?programEdited=1");
        break;
    case 'getRoster':
        $program = Program::get($_GET['programID'] ?? -1);

        echo json_encode($program->getRoster() ?? '');
        exit(200);

    case 'getUserByID':
        if (isset($_GET['id'])) {
            $user = User::get($_GET['id']);
            echo json_encode($user);
            exit(200);
        } else {
            exit(400);
        }
    case 'register':
        $programID = $_GET['programID'] ?? '';
        $mysql = new MySQLConnection();
        $a = new Auth();
        $u = $a->getCurrentUser($_COOKIE['cs341_uuid']);
        $sql = "INSERT INTO Participant_Programs (ParticipantID, ProgramID) VALUES ($u->userID, $programID);";
        mysqli_query($mysql->conn, $sql);
        header("Location: /program");
        break;
    case 'search_programs':
        if (isset($_REQUEST['v'])) {
            $result = Program::search($_REQUEST['v']);
            echo json_encode($result);
            exit(200);
        }
        break;
    case 'get_programs':
        $result = Program::getPrograms($_REQUEST['page'] ?? 0);
        echo json_encode($result);
        exit(200);
    case 'get_staff':
        $result = Staff::getStaff($_REQUEST['page'] ?? 0);
        echo json_encode($result);
        exit(200);
    case 'search_users':
        if (isset($_REQUEST['v'])) {
            $result = User::search($_REQUEST['v']);
            echo json_encode($result);
            exit(200);
        }
        break;
    case 'search_staff':
        if (isset($_REQUEST['v'])) {
            $result = Staff::search($_REQUEST['v']);
            echo json_encode($result);
            exit(200);
        }
        break;
    default:
        // bad request.
//        http_send_status(400);
        exit(400);
}

//if (isset($_GET['debug'])) {

//}

