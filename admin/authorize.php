<?php
require_once 'service/Auth.php';
$auth = new Auth();
$user = $auth->authorizeStaff();
if (!$user) {
    echo "<script>window.location = '/login.php?reauth=1';</script>";
}