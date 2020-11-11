<?php
require_once 'Auth.php';
require_once 'MySQLConnection.php';

// TODO: This needs to be moved to models/Program.php

// Verify that they are indeed a staff member.
$auth = new Auth();
$user = $auth->authorizeStaff();

if (!$user) {
    http_send_status(400);
    exit(400);
}

$mysql = new MySQLConnection();

$program_name = mysqli_real_escape_string($mysql->conn, $_REQUEST['name']);
$location = mysqli_real_escape_string($mysql->conn, $_REQUEST['location']);
$capacity = mysqli_real_escape_string($mysql->conn, $_REQUEST['capacity']);
$sdate = mysqli_real_escape_string($mysql->conn, $_REQUEST['start_date']);
$edate = mysqli_real_escape_string($mysql->conn, $_REQUEST['end_date']);
$stime = mysqli_real_escape_string($mysql->conn, $_REQUEST['start_time']);
$etime = mysqli_real_escape_string($mysql->conn, $_REQUEST['end_time']);
$mem_price = mysqli_real_escape_string($mysql->conn, $_REQUEST['mem_price']);
$non_mem_price = mysqli_real_escape_string($mysql->conn, $_REQUEST['non_mem_price']);
$description = mysqli_real_escape_string($mysql->conn, ($_REQUEST['description'] ?? ''));

$dow = 0;
foreach ($_REQUEST['DayOfWeek'] as $item) {
    $dow |= $item;
}

//var_dump($program_name, $location, $capacity, $sdate, $stime, $mem_price, $non_mem_price, $description);

$sql = "INSERT INTO Programs (Name, DescFile, Capacity, MemberFee, NonMemberFee, Location, start_date, end_date, start_time, end_time, day_of_week, ShortDesc)" .
    " VALUES ('$program_name', '/tmp/null', '$capacity', '$mem_price', '$non_mem_price', '$location', '$sdate', '$edate', '$stime', '$etime', '$dow', '$description');";
$result = mysqli_query($mysql->conn, $sql);

if ($result) {
    header("Location: /staff/?programCreated=1");
    http_send_status(200);
    exit(200);
}
header("Location: /staff/addProgram.php?failed=1");
http_send_status(400);
exit(400);