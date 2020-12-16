<html lang="en">
<head>
    <title>YMCA Home</title>
</head>
<?php
require 'models/Program.php';
include 'menu.php';
$loggedIn = $auth->isLoggedIn();
$userProgs = array();

echo "<script>
if (window.sessionStorage.getItem('firstVisit') == null) {
    window.sessionStorage.setItem('firstVisit', 'true');
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
} 
</script>";

if (isset($_REQUEST['loggedOut'])) {
    echo "
    <script>
        Swal.fire({
            title: 'Welcome!',
            html: 'You just logged out and will not be able to register for programs.  Would you like to log in?',
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
    echo "\t\t<a href='/service/api.php?action=cancel&programID=$program->id' class='btn btn-block' style='background-color: red; color: white '>Cancel Registration</a>";
    echo "\t</div>";
    echo "</div>";
}

?>
<!--<h2 class="display-4 text-center mt-5">Good Morning--><?php //echo ($GLOBALS['user'] ? ', ' . $GLOBALS['user']->FirstName : '') ?><!--!</h2>-->


<?php
if ($loggedIn) {
    $notif = '';
    $id = $loggedIn->userID ?? $loggedIn->ID;
    $progs = Program::getParticipantProgram($id);
    $mysql = new MySQLConnection();
    foreach ($progs as $obj) {
        if ($obj->inactive) {
            $notif .= "Program " . $obj->name . " has been cancelled." . "<br>";
            $sql = "SELECT ProgramID FROM Participant_Programs WHERE ProgramID = $obj->id";
            $sql = "UPDATE Participant_Programs SET status = 2 WHERE ProgramID = $obj->id && ParticipantID = $loggedIn->ID";
        }
    }
    $progs = Program::getParticipantProgram($id, 0);

    echo '
    <div class="container">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="jumbotron shadow-sm">
                        <h2 class="mt-1"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
  <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
</svg> System Notifications</h2>
                        <tbody id="notifications_area">
              
                    ';
                    echo $notif;
                    echo '      
              
                        </tbody>
                    </div>
                </div>
            </div>
            <hr class="mt-0"> 
                <h2>Registered Programs</h2>
                <div class="row mb-5">';
                    foreach ($progs as $obj) {
                        if (!$obj->inactive) {
                            print_program($obj);
                        }
                    }
                    echo ' 
                </div>      
    </div>';
} else {
    echo '
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
    ';
}
?>
</html>