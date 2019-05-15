<?php
/* 	Alex Childers
	Last modified: 2019/05/08
*/

/* 	Function: select_volunteer 

	Purpose: Expects a valid username and password to exist in the $_SESSION
		array. Dynamically creates a drop-down menu of volunteers for the user
		to choose from.
*/

function select_volunteer()
{
	// try connecting to Oracle 
	$conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);

	// query volunteers and their IDs from the database 
	$vol_query_str = "select	w.worker_id, first_name, last_name
					  from		worker w join volunteer v
								on w.worker_id = v.worker_id 
					  order by 	last_name"; 
	$vol_query = oci_parse($conn, $vol_query_str); 
	oci_execute($vol_query); 
	
	// create a form with a dropdown of volunteers and their IDs 
	?>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>"
		  method="post">
		<fieldset>
			<legend> Delete a volunteer </legend>
			<p> *Be certain to double-check which volunteer you
				want to delete before submitting! </p>
			<label for="vol_id"> Volunteer </label>
			<select id="vol_id" name="vol_id" >
				<?php
				
				// create dropdown options from the query 
				while(oci_fetch($vol_query))
				{
					$id = oci_result($vol_query, "WORKER_ID"); 
					$first_name = oci_result($vol_query, "FIRST_NAME"); 
					$last_name = oci_result($vol_query, "LAST_NAME"); 
					?>
					<option value="<?= $id ?>">
						<?= $last_name . ", " . $first_name . " - " . $id ?>
					</option>
					<?php
				}
				oci_free_statement($vol_query); 
				oci_close($conn); 
				?> 
			</select>
		</fieldset>
		<div class="sub_button">
			<input type="submit" name="see_menu" value="Back to menu" /> 
			<input type="submit" name="delete_vol" value="Delete volunteer" /> 
		</div> 
	</form>
	<?php
}
?>