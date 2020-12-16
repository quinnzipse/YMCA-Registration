<?php
// ANYTHING in this file will require the user to be logged in.
// This file is the middle-man for client-server communication!
// common theme:
//      if(something fails) {
//          tell the client it failed
//      }

set_include_path('/var/www/html');
require_once 'authorize.php';
require_once 'models/Program.php';
require_once 'models/User.php';
require_once 'models/Staff.php';

// get the action or blank if it's not set.
$action = $_GET['action'] ?? '';

//check what the api is being used for
switch ($action) {
    case 'addStaff':
        if (isset($_POST['id'])) {
            // Consider reworking this to only return one element...
            $user = User::get($_POST['id']);

            // Creates a staff member.
            if (!$user->makeStaff()) {
                header("Location: /admin/staff/addStaff.php?failed=1");
                http_response_code(400);
                exit(400);
            }

            header("Location: /admin/staff/?staffAdded=1");
            exit(200);
        }
        break;
    case 'enableUser':
        // If given an id, enable it.
        if (isset($_REQUEST['id'])) {
            $user = User::get($_REQUEST['id']);

            // If enable fails, send error code
            if (!$user->enable()) {
                http_response_code(500);
            }
        }
        break;
    case 'createProgram':
        $program = new Program();

        // try to create the program.
        if (!$program->createProgram()) {
            // if it fails, let the client know.
            header("Location: /admin/programs/addProgram.php?failed=1");
            http_response_code(400);
            exit(400);
        }

        header("Location: /admin/programs/?programCreated=1");
        break;
    case 'editProgram':
        if (!Program::editProgram((int)$_POST['id'])) {
            header("Location: /admin/programs/editProgram.php?p=" . $_POST['id'] . "&failed=1");
            http_response_code(400);
            exit(400);
        }
        header("Location: /admin/programs/?programEdited=1");
        break;
    case 'editStaff':
        if (!Staff::editStaff((int)$_POST['id'])) {
            header("Location: /admin/staff/editStaff.php?s=" . $_POST['id'] . "&failed=1");
            http_response_code(400);
            exit(400);
        }
        header("Location: /admin/staff/?staffEdited=1");
        break;
    case 'getRoster':
        $program = Program::get($_GET['programID'] ?? -1);

        // get the roster, json encode it, and send it to the client.
        echo json_encode($program->getRoster() ?? '');
        exit(200);
    case 'getProgramsByUser':
        if ($_GET['id']) {
            // get the programs that belong to users.
            $programs = Program::getProgramsByUser($_GET['id']);

            // display it
            echo json_encode($programs);
            http_response_code(200);
            exit(200);
        }
        break;
    case 'getUserByID':
        if (isset($_GET['id'])) {
            $user = User::get($_GET['id']);
            echo json_encode($user);
            exit(200);
        }
        break;
    case 'editMember':
        if (!User::edit((int)$_POST['id'])) {
            header("Location: /admin/members/editMember.php?p=" . $_POST['id'] . "&failed=1");
            http_response_code(400);
            exit(400);
        }
        header("Location: /admin/members/?memberEdited=1");
        break;
    case 'disableMember':
        if (isset($_REQUEST['id'])) {
            $user = User::get((int)$_REQUEST['id']);
            if (!$user->disableUser()) {
                http_response_code(400);
                exit(400);
            }
        }
        exit(200);
    case 'cancel_program':
        if (isset($_REQUEST['id'])) {
            $prog = Program::get((int)$_REQUEST['id']);
            if (!$prog->disableProgram()) {
                http_response_code(400);
                exit(400);
            }
        }
        exit(200);
    case 'register':
        //register a new program
        $programID = $_GET['programID'] ?? '';

        $mysql = new MySQLConnection();
        $a = new Auth();
        // uses the cookie to get the user
        $u = $a->getCurrentUser($_COOKIE['cs341_uuid']);

        // make sure you don't duplicate in the case of reregistering after canceling a class.
        $sql = "SELECT * FROM Participant_Programs WHERE (ParticipantID = $u->userID AND ProgramID = $programID);";

        if (mysqli_query($mysql->conn, $sql)->num_rows > 0) {
            // register by marking the database
            $sql = "UPDATE Participant_Programs SET status=0 WHERE (ParticipantID = $u->userID AND  ProgramID = $programID);";
        } else {
            // register by inserting row.
            $sql = "INSERT INTO Participant_Programs (ParticipantID, ProgramID, status) VALUES ($u->userID, $programID, 0);";
        }
        mysqli_query($mysql->conn, $sql);
        header("Location: /program");
        break;
    case 'cancel':
        //cancel a program
        $programID = $_GET['programID'] ?? '';
        $mysql = new MySQLConnection();
        $a = new Auth();
        // get the user by the auth cookie
        $u = $a->getCurrentUser($_COOKIE['cs341_uuid']);

        // set their registrations to canceled status.
        $sql = "UPDATE Participant_Programs SET status=1 WHERE (ParticipantID = $u->userID AND ProgramID = $programID);";
        mysqli_query($mysql->conn, $sql);

        // redirect them.
        header("Location: /accountinfo.php");
        break;
    case 'search_programs':
        // request 'v' is search term
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
    case 'get_members':
        $result = User::getUsers($_REQUEST['page'] ?? 0);
        echo json_encode($result);
        exit(200);
    case 'search_users':
        // request 'v' is search term.
        if (isset($_REQUEST['v'])) {
            $result = User::search($_REQUEST['v']);
            echo json_encode($result);
            exit(200);
        }
        break;
    case 'search_staff':
        // request 'v' is search term.
        if (isset($_REQUEST['v'])) {
            $result = Staff::search($_REQUEST['v']);
            echo json_encode($result);
            exit(200);
        }
        break;
    case 'revoke_access':
        if (isset($_REQUEST['id'])) {
            $staff = Staff::get((int)$_REQUEST['id']);
            if (!$staff->revokeStaffAccess()) {
                http_response_code(400);
                exit(400);
            }
        }
        exit(200);
    default:
        // If it makes it bad request.
        http_response_code(400);
        exit(400);
}


