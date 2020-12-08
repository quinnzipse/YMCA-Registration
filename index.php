<html lang="en">
<head>
    <title>YMCA Home</title>
</head>
<?php
require 'models/Program.php';
include 'menu.php';
$loggedIn = $auth->isLoggedIn();
$userProgs = array();

if (isset($_REQUEST['loggedOut'])) {
    echo "
    <script>
        Swal.fire({
            title: 'Welcome!',
            html: 'You are not logged in and cannot register for programs right now.  Would you like to log in?',
            showConfirmButton: true,
            confirmButtonText: 'Log In!',
            showDenyButton: true,
            denyButtonText: 'Not Now'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.replace('login.php');
            }
        })
    </script>
    ";
} else if (isset($_REQUEST['loggedIn'])) {
    echo "
    <script>
        Swal.fire({
            title: 'Welcome $loggedIn->FirstName!',
            showConfirmButton: true,
            confirmButtonText: 'Browse Classes!',
            showDenyButton: true,
            denyButtonText: 'Not Now'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.replace('/program/index.php');
            }
        })
    </script>
    ";
}

function print_program($program) {
    $sdate = $program->startDate->format("M, d Y");
    $edate = $program->endDate->format("M, d Y");
    $stime = $program->startTime->format('g:i A');
    $etime = $program->endTime->format('g:i A');
    $days_of_week = join("'s, ", $program->getDaysOfWeek());
    echo "<div class='col-lg-4 col-md-6 mt-3 '>";
    echo "\t<div class='card border-dark h-100' style='border-radius: 20px'>";
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
    echo "\t\t<a href='#' class='btn btn-block' style='background-color: red; color: white '>Cancel Registration</a>";
    echo "\t</div>";
    echo "</div>";
}

?>
<!--<h2 class="display-4 text-center mt-5">Good Morning--><?php //echo ($GLOBALS['user'] ? ', ' . $GLOBALS['user']->FirstName : '') ?><!--!</h2>-->

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 72vw; margin-left: auto; margin-right: auto; margin-top: 5vh; max-height: 128vh">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active" data-interval="4000">
            <img src="../img\swim.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-interval="4000">
            <img src="../img\run.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-interval="4000">
            <img src="../img\weightLifting.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-interval="4000">
            <img src="../img\yoga.jpg" class="d-block w-100" alt="...">
        </div>
    </div>

</div>

<div class="container">
    <div class="row mt-3">
        <?php
            if ($loggedIn) {
                $progs = Program::getParticipantProgram($loggedIn->ID);
                foreach ($progs as $obj) {
                    print_program($obj);
                }
            }
        ?>
    </div>
</div>




</html>