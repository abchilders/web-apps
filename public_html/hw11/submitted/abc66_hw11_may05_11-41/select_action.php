<?php
/* 	Alex Childers
	Last modified: 2019/04/28
*/

/*	Function: select_action

	Purpose: Expects a username and password; returns nothing. Destroys the 
		session if the username or password is invalid. Otherwise, displays
		some options for actions that the user can take. 
		
	CURRENTLY STILL A STUB 
*/

function select_action($username, $password)
{
	// try connecting to Oracle
	$conn = hsu_conn_sess($username, $password); 
	
	?>
	<p> select_action(): displays some actions that the user can choose from
	<ul>
		<li> <a href="https://nrs-projects.humboldt.edu/~abc66/cs328/hw8/custom-call.php">
			custom-call.php
			</a></li>
		<li> <a href="https://nrs-projects.humboldt.edu/~abc66/cs328/hw9/custom-session1.php">
			custom-session1.php</a></li>
		<li> insert, update, or delete some data into the LCPB database</li>
	</ul>
	
	<p>
		<a href="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>">
			Go back to login.
		</a>
	</p>
	<?php
	oci_close($conn); 
}
?>