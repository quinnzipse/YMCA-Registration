<?php 
        require "../models/Program.php";
	include 'menu.php';
	if ($user == null):
		header("Location: $host/login.php");
	endif;
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
<h2>Current Classes</h2>

<h2>Upcoming Classes</h2>
<!-- TODO: Make dashboard that shows Registered class info on left and the account information on the right-->
