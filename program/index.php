<?php
require "models/Program.php";
include "menu.php";
$progs = Program::search($_GET['s'] ?? '');
$loggedIn = $auth->isLoggedIn();
$userProgs = array();
if ($loggedIn) $userProgs = Program::getParticipantProgram($loggedIn->userID);


/**
 * print_program Generates a card for a given program. 
 * 
 * @param Program $program 
 * @param bool $disabled 
 * @param bool $registered 
 * @access public
 * @return void
 */
function print_program(Program $program, bool $disabled, bool $registered)
{
    global $loggedIn;
    $pID = $program->id;
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
        $button = 'Register For Class';
        if ($disabled) $button = 'Time Conflict';
        if($program->programCount() >= $program->capacity) $button = 'Program is Full';
        if ($registered) $button = 'Already Registered';

        if ($button == 'Program is Full') {
            echo "\t\t<a class='btn btn-block'; style=background-color: #0851c7; color: white; >Program is full</a>";
        } else {
            echo "\t\t<a href='/service/api.php?action=register&programID=$pID' class='btn btn-block " .
                ($disabled ? 'disabled' : '') . "' style='background-color: #0851c7; color: white '>" .
                $button . "</a>";
        }
    } else {
        if ($program->programCount() >= $program->capacity) {
            echo "\t\t<a class='btn btn-block'; style=background-color: #0851c7; color: white; >Program is full</a>";
        } else {
            echo "\t\t<a href='../login.php' class='btn btn-block' style='background-color: #0851c7; color: white '>Register For Class</a>";
        }
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
    <div class="row mt-5">
        <div class="col-md-6">
            <h2>Browse Programs</h2>
        </div>
        <form class="col-md-6 mb-0 mt-2">
            <label for="search" class="sr-only">Search</label>
            <div class="input-group-sm input-group">
                <input type="text" id="search" name="s" class="form-control"
                       value="<?php echo $_REQUEST['s'] ?? ''; ?>"
                       placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-primary">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search"
                             fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd"
                                  d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <hr class="mt-0">

    <div class="row mb-5">
        <?php
        foreach ($progs as $obj) {
            if($obj->inactive) continue;
            $disable = false;
            $registered = false;
            foreach ($userProgs as $userProg) {
                if ($obj->isConflicting($userProg)) $disable = true;
                if ($obj->id == $userProg->id) $registered = true;
            }
            print_program($obj, $disable, $registered);
        }
        ?>
    </div>
</div>
</html>
