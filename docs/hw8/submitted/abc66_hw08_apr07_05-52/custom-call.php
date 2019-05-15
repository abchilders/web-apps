<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/07

    you can run this using the URL:
		https://nrs-projects.humboldt.edu/~abc66/cs328/hw8/custom-call.php
		
	NOTE!!! Make sure to run 325populate.sql twice, due to an odd bug related
	to sequence generation that I still haven't solved. Otherwise, worker and 
	volunteer IDs will not be consistent across all tables in the database.

-->

<head>
    <title> Remove Volunteer </title>
    <meta charset="utf-8" />
	
	<?php
		/* 
		error reporting for debugging:
			ini_set('display_errors', 1);
			error_reporting(E_ALL); 
		*/

        // include required PHP functions 
        require_once("hsu_conn.php");
	?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
    <link href="custom.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div class="header">
		<h1> Loving Care Pet Boarding: Remove Volunteer </h1>
		
		<h2> Alex Childers - CS 328 </h2>
	</div>
	
	<?php
	// has a username already been entered?
	if (! array_key_exists("username", $_POST))
	{
		// if not, generate a form
		?>
		<form action="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>"
			  method="post">
			<fieldset>
				<legend> Delete a volunteer </legend>
				<fieldset>
					<legend> Select volunteer </legend>
					<p> *Be certain to double-check which volunteer you
						want to delete before submitting! </p>
					<label for="vol_id"> Volunteer </label>
					<select id="vol_id" name="vol_id" >
						<option value="300020"> 300020 </option>
						<option value="300022"> 300022 </option>
						<option value="300024"> 300024 </option>
						<option value="300026"> 300026 </option>
						<option value="300028"> 300028 </option>
						<option value="300030"> 300030 </option>
						<option value="300032"> 300032 </option>
						<option value="300034"> 300034 </option>
						<option value="300036"> 300036 </option>
						<option value="300038"> 300038 </option>
					</select>
				</fieldset>
		<?php
			require_once("oracle-login-fieldset.html"); 
		?>
			</fieldset>
		</form>
		<?php
	}
	
	// if a username already exists, respond to the form--
	// log into Oracle and delete that volunteer
	else
	{
		// log in to Oracle
		$username = strip_tags($_POST["username"]); 
		$password = $_POST["password"]; 
		$conn = hsu_conn($username, $password); 
		
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
		$vol_first_name = oci_result($vol_stmt, "FIRST_NAME");
		$vol_last_name = oci_result($vol_stmt, "LAST_NAME"); 
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
		<p> Volunteer <?= $vol_id ?>, <?= $vol_first_name . " " . 
			$vol_last_name ?>, has been deleted.
		</p>
		
		<p>
			<a href="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>">
				Delete another volunteer.
			</a>
		</p>
		<?php
	}

	require_once("328footer.html"); 
?>