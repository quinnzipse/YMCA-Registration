<?php
set_include_path('/var/www/html');
require_once 'authorize.php';
require_once 'models/Program.php';

// ANYTHING in this file will require the user to be logged in.
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'createProgram':
        $program = new Program();
        $program->createProgram($_POST['']);
        break;
    default:
        // bad request.
        http_send_status(400);
        exit(400);
}

if (isset($_GET['debug'])) {
    echo " -- GET -- ";
    var_dump($_GET);
    echo " -- POST -- ";
    var_dump($_POST);
}