<?php
require "models/Program.php";
include "menu.php";
$page = $_GET['page'] ?? 0;
$progs = Program::getPrograms($page);
$loggedIn = $auth->isLoggedIn();
$userProgs = array();
if ($loggedIn) $userProgs = Program::getParticipantProgram($loggedIn->userID);


function print_program($program, bool $disabled, bool $registered)
{
    global $loggedIn;
    $pID = $program->getID();
    $sdate = $program->startDate->format("M, d Y");
    $edate = $program->endDate->format("M, d Y");
    $stime = $program->startTime->format('g:i A');
    $etime = $program->endTime->format('g:i A');
    $days_of_week = join("'s, ", $program->getDaysOfWeek());
    echo "<div class='col-lg-4 col-md-6 mt-3 '>";
    echo "\t<div class='card border-dark h-100' style='border-radius: 10px'>";
    echo "\t\t<div class='card-body'>";
    echo "\t\t\t<h5 class='card-title'>$program->name</h5>";
    echo "\t\t\t<p class='card-text'>$program->shortDesc</p>";
    echo "\t\t</div>";
    echo "\t\t<ul class='list-group list-group-flush'>";
    echo "\t\t\t<li class='list-group-item'>$program->location</li>";
    echo "\t\t\t<li class='list-group-item'>";
    echo "\t\t\t\t<p>$sdate to $edate</p>";
    echo "\t\t\t\t<p> $days_of_week's, $stime - $etime</p>";
    echo "\t\t\t</li>";
    echo "\t\t\t<li class='list-group-item'><p>Member Fee:   $$program->memberFee</p> <p>Non Member Fee:   $$program->nonMemberFee</p></li>";
    echo "\t\t</ul>";

    if ($loggedIn) {
        echo "\t\t<a href='/service/api.php?action=register&programID=$pID' class='btn btn-block " . ($disabled ? 'disabled' : '') . "' style='background-color: #0851c7; color: white '>" . ($registered ? 'Already Registered' : 'Register For Class') . "</a>";
    } else {
        echo "\t\t<a href='../login.php' class='btn btn-block' style='background-color: #0851c7; color: white '>Register For Class</a>";
    }
    echo "\t</div>";
    echo "</div>";
}

?>
<html lang="en">
<head>
    <title>Browse Programs</title>
</head>
<div class="container">
    <div class="row mt-3">
        <?php
        foreach ($progs as $obj) {
            $disable = false;
            $registered = false;
            foreach ($userProgs as $userProg) {
                if ($obj->isConflicting($userProg)) $disable = true;
                if ($obj->getID() == $userProg->getID()) $registered = true;
            }
            print_program($obj, $disable, $registered);
        }
        ?>
    </div>
</div>
</html>
