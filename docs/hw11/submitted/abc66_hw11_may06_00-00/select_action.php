<?php
/* 	Alex Childers
	Last modified: 2019/05/05
*/

/*	Function: select_action

	Purpose: Expects a username and password; returns nothing. Destroys the 
		session if the username or password is invalid. Otherwise, displays
		some options for actions that the user can take. 

*/

function select_action($username, $password)
{
	// try connecting to Oracle
	$conn = hsu_conn_sess($username, $password); 
	
	// select an action 
	?>
	<form method="post" 
		action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>">
		<fieldset>
			<legend> Select database action </legend>
			<select required="required" name="action">
				<option value="delete_vol"> Delete volunteer </option>
				<option value="add_owner_info"> Add owner contact information
					</option>
				<option value="update_pet"> Update pet information </option>
			</select>
		</fieldset> 
		<input type="submit" name="logout" value="Log out" />
		<input type="submit" name="choose_action" value="Submit" /> 
	</form>
	<?php
	oci_close($conn); 
}
?>