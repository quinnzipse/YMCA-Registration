
<?php
//page for viewing account info.

//program model is used for displaying registered classes
require "models/Program.php";
//including the standard menu
include 'menu.php';
//check whether the user is logged in
if ($user == null):
    //if not logged in, the user is sent to the login page
    header("Location: $host/login.php");
endif;

/**
 * function to print the programs that the user is registered for
 *
 * @param $program is the program that needs to be displayed on the page
 */
function print_program($program)
{
    //getting the info about the program to be displayed
    $sdate = $program->startDate->format("M, d Y");
    $edate = $program->endDate->format("M, d Y");
    $stime = $program->startTime->format('g:i A');
    $etime = $program->endTime->format('g:i A');
    $days_of_week = join("'s, ", $program->getDaysOfWeek());

    //print the program
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
<h1>
    <?php
    echo "Welcome, $user->FirstName" . "!";
    ?>
</h1>
<h2>Account Info</h2>
<div class="card shadow my-4" id="detail-card">
    <div class="card-body">
        <h3 class="card-title" id="name">
            <span id="lastName"><?php echo "$user->LastName"; ?></span>
            <span id="firstName"><?php echo "$user->FirstName"; ?></span>
        </h3>
        <hr>
        <div class="card-text">
            <div class="row">
                <div class="col-lg-6">
                    <small class="d-block mb-2"><strong>Email: </strong></small>
                    <a id="email" href=""><?php echo "$user->Email"; ?></a>
                </div>
                <div class="col-lg-6">
                    <small class="d-block mb-2"><strong>Membership Status: </strong></small>
                    <span id="status"><?php echo "$user->MembershipStatus"; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($DEBUG):
    //display the users ID when debugging
    echo "<tr>
			<td>ID</td>
			<td>$user->ID</td>
		</tr>";
endif;
?>
<br/>
<button>UPDATE</button>
<br/>

<h2>Registered Classes</h2>
<div class="container">
    <div class="row mt-3">
        <?php
        //get a array of programs the user it registered for and print them
        $progs = Program::getParticipantProgram($user->ID ?? $user->userID);
        foreach ($progs as $obj) {
            print_program($obj);
        }
        ?>
    </div>
    <br/>
    <br/>
</div>
