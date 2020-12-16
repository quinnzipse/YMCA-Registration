<?php
//creates the authentication
require_once 'Auth.php';
$auth = new Auth();
$user = $auth->authorize();