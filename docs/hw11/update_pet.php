<?php
/* 	Alex Childers
	Last modified: 2019/05/05
*/

/* 	Function: update_pet 

	Purpose: Expects a valid username and password to exist in the $_SESSION
		array. Creates a form showing inputs for pet information.
*/

function update_pet()
{
	?>
	<p> Called update_pet, which will show a form with places to input 
		pet information. </p> 
	
	<a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		Log out. 
	</a> 
	<?php
}
?>