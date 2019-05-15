<?php
/* 	Alex Childers
	Last modified: 2019/05/05
*/

/* 	Function: select_volunteer 

	Purpose: Expects a valid username and password to exist in the $_SESSION
		array. Dynamically creates a drop-down menu of volunteers for the user
		to choose from.
*/

function select_volunteer()
{
	?>
	<p> Called select_volunteer, which will show a drop-down menu of 
		volunteers. </p> 
	
	<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		Log out. 
	</a> 
	<?php
}
?>