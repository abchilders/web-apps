<?php
/* 	Alex Childers
	Last modified: 2019/04/22
*/
	
/* 
	Function: delete_volunteer
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain a valid volunteer ID, and the $_SESSION array should contain a 
		valid Oracle username and password. Deletes the volunteer from all
		tables they are in. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function delete_volunteer()
{
	// does a volunteer ID exist in $_POST? 
	if( (! array_key_exists("vol_id", $_POST)) or
		($_POST["vol_id"] == "") or 
		(! isset($_POST["vol_id"])) )
	{
		destroy_and_exit("Must select a volunteer."); 
	}
	
	// log in to Oracle
	$username = $_SESSION["username"]; 
	$password = $_SESSION["password"];  
	$conn = hsu_conn_sess($username, $password); 
	
	// if we've reached here, we have successfully connected.
	
	// select the volunteer's name before deleting; will use for feedback
	$vol_query_str = "select first_name, last_name
					  from	 worker w 
					  where	 w.worker_id = :vol_id";
	$vol_stmt = oci_parse($conn, $vol_query_str);
	
	// create bind variable
	$vol_id = strip_tags($_POST["vol_id"]);
	oci_bind_by_name($vol_stmt, ":vol_id", $vol_id);
	oci_execute($vol_stmt, OCI_DEFAULT); 
	
	// store the results of that query - should only return one row, 
	// since worker IDs are unique
	oci_fetch($vol_stmt);
	$vol_name = oci_result($vol_stmt, "FIRST_NAME") . " " . oci_result($vol_stmt, "LAST_NAME"); 
	oci_free_statement($vol_stmt); 
	
	// call delete_volunteer()
	$delete_vol_call = "begin delete_volunteer(:vol_id); end;";
	$delete_vol_stmt = oci_parse($conn, $delete_vol_call);  
	
	// set input bind variable vol_id
	oci_bind_by_name($delete_vol_stmt, ":vol_id", $vol_id);
	
	// execute procedure call
	oci_execute($delete_vol_stmt, OCI_DEFAULT); 
	oci_commit($conn);
	oci_free_statement($delete_vol_stmt);
	oci_close($conn);
	
	// give feedback
	?>
	<p> Volunteer <?= $vol_id ?>, <?= $vol_name ?>, has been deleted.
	</p>
	
	<p>
		<a href="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>">
			Delete another volunteer.
		</a>
	</p>
	<?php
}
?>