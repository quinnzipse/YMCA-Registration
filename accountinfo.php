<?php 
    require "models/Program.php";
	include 'menu.php';
	if ($user == null):
		header("Location: $host/login.php");
	endif;

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
<h1>
	<?php
		echo "Welcome, $user->FirstName" . "!";
	?>
</h1>
<h2>Account Info</h2>
<table class="table table-bordered">
	<tr>
		<td>Email</td>
		<td><?php echo "$user->Email"; ?></td>
	</tr>
	<tr>
		<td>Password</td>
		<td></td>
	</tr>
	<tr>
		<td>First Name</td>
		<td><?php echo "$user->FirstName"; ?></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><?php echo "$user->LastName"; ?></td>
	</tr>
	<tr>
		<td>Membership Status</td>
		<td><?php echo "$user->MembershipStatus"; ?></td>
	</tr>
	<?php if($DEBUG): 
		echo "<tr>
			<td>ID</td>
			<td>$user->ID</td>
		</tr>";
	endif;
	?>
</table>

<br />
<h2>Registered Classes</h2>
<div class="container">
	<div class="row mt-3">
		<?php 
			$progs = Program::getParticipantProgram($user->ID);
        	foreach ($progs as $obj) {
        		print_program($obj);        
        	}
		?>
	</div>
</div>
