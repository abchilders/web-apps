<?php
/* 	Alex Childers
	Last modified: 2019/05/10
*/
	
/* 
	Function: submit_pet_update
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain pet information. 
		The $_SESSION array should contain a valid Oracle username and 
		password. Adds the new pet information to the Pet table.
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function submit_pet_update()
{
	// does a pet ID exist in $_POST? 
	if( (! array_key_exists("pets", $_POST)) or
		($_POST["pets"] == "") or 
		(! isset($_POST["pets"])) )
	{
		destroy_and_exit("Must select a pet."); 
	}
	
	// log in to Oracle
	$username = $_SESSION["username"]; 
	$password = $_SESSION["password"];  
	$conn = hsu_conn_sess($username, $password); 
	
	// if we've reached here, we have successfully connected.
	
	// select the pet's name before updating; will use for feedback
	$pet_query_str = "select	pet_name
						from	pet
						where 	pet_id = :pet_id";
	$pet_stmt = oci_parse($conn, $pet_query_str); 
	
	// create bind variable
	$pet_id = strip_tags($_POST["pets"]);
	oci_bind_by_name($pet_stmt, ":pet_id", $pet_id);
	oci_execute($pet_stmt, OCI_DEFAULT); 
	
	// store the results of that query - should only return one row, 
	// since pet IDs are unique
	oci_fetch($pet_stmt);
	$old_pet_name = oci_result($pet_stmt, "PET_NAME"); 
	oci_free_statement($pet_stmt);

	// does a name exist in $_POST?
	if ((! array_key_exists("name", $_POST)) or
		 ($_POST["name"] == "") or 
		 (! isset($_POST["name"])) )
	{
		?>
		No new name was added. 
		<?php
	}
	
	else
	{
		$new_name = strip_tags($_POST["name"]); 
		
		// update the database with this new name 
		$name_update_str = "update 	pet
							set		pet_name = :new_name
							where	pet_id = :pet_id"; 
		$name_update = oci_parse($conn, $name_update_str); 
		
		// set bind variables 
		oci_bind_by_name($name_update, ":new_name", $new_name); 
		oci_bind_by_name($name_update, ":pet_id", $pet_id);
		
		// execute update 
		oci_execute($name_update, OCI_DEFAULT); 
		oci_commit($conn); 
		oci_free_statement($name_update);
	}
	
	// display new pet information 
	// first, query the pet now 
	$pet_query_str = "select 	*
					  from 		pet
					  where		pet_id = :pet_id"; 
	$pet_query = oci_parse($conn, $pet_query_str); 
	oci_bind_by_name($pet_query, ":pet_id", $pet_id); 
	oci_execute($pet_query, OCI_DEFAULT);
	oci_fetch($pet_query); 
	?>
	
	<table>
		<caption> Basic information for pet #<?= $pet_id ?> </caption>
		<tr>
			<th scope="row"> Name </th> 
			<td> <?= oci_result($pet_query, "PET_NAME") ?> </td> 
		</tr>
		<tr>
			<th scope="row"> Gender </th>
			<td><?= oci_result($pet_query, "SEX") ?> </td>
		</tr>
		<tr>
			<th scope="row"> Spayed/neutered? </th>
			<td><?= oci_result($pet_query, "IS_SPAYED_NEUTERED") ?></td>
		</tr>
		<tr>
			<th scope="row"> Birthday </th>
			<td><?= oci_result($pet_query, "BIRTHDAY") ?></td>
		</tr>
		<tr>
			<th scope="row"> Pet type </th>
			<td><?= oci_result($pet_query, "PET_TYPE") ?></td>
		</tr>
		<tr>
			<th scope="row"> Owner ID </th>
			<td><?= oci_result($pet_query, "OWNER_ID") ?></td>
		</tr>
	</table>
	
	<form method="post"
		  action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		<div class="sub_button">				
			<input type="submit" name="see_menu" value="Back to menu" />
			<input type="submit" name="add_more" 
				value="Update more information" />
		</div>
	</form>
	<?php
	oci_free_statement($pet_query); 
	oci_close($conn); 
}
?>