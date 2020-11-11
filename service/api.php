<?php
set_include_path('/var/www/html');
require_once 'authorize.php';
require_once 'models/Program.php';

echo " -- GET -- ";
var_dump($_GET);
echo " -- POST -- ";
var_dump($_POST);

// ANYTHING in this file will require the user to be logged in.
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'createProgram':
        $program = new Program();
        if (!$program->createProgram()) {
//            header("Location: /staff/addProgram.php?failed=1");
            http_send_status(400);
            exit(400);
        }
        header("Location: /staff/?programCreated=1");
        break;
    default:
        // bad request.
        http_send_status(400);
        exit(400);
}

//if (isset($_GET['debug'])) {

//}

http_send_status(200);
exit(200);