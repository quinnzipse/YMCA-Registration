<?php
require_once '../service/Auth.php';
$auth = new Auth();
$user = $auth->authorizeStaff();