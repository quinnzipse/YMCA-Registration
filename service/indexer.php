<?php
require_once 'MySQLConnection.php';
$mysql = new MySQLConnection();

$sql = 'SELECT ID, FirstName, LastName, Email FROM Participants';
$result = mysqli_query($mysql->conn, $sql);

$rows = mysqli_fetch_all($result);

foreach ($rows as $row) {
    $id = $row[0];
    $first = $row[1];
    $last = $row[2];
    $email = $row[3];

    $first = metaphone($first);
    $last = metaphone($last);
    $email = metaphone($email);

    $index = "$first $last $email";

    $sql = "UPDATE Participants SET indexed = '$index' WHERE ID = $id";
    $result = mysqli_query($mysql->conn, $sql);

    if(!$result){
        var_dump($index);
        return;
    }
}

$sql = 'SELECT ID, Name, Location FROM Programs';
$result = mysqli_query($mysql->conn, $sql);

$rows = mysqli_fetch_all($result);

foreach ($rows as $row) {
    $id = $row[0];
    $name = $row[1];
    $loc = $row[2];

    $name = metaphone($name);
    $loc = metaphone($loc);

    $index = "$name $loc";

    $sql = "UPDATE Programs SET indexed = '$index' WHERE ID = $id";
    $result = mysqli_query($mysql->conn, $sql);

    if(!$result){
        var_dump($index);
        return;
    }
}