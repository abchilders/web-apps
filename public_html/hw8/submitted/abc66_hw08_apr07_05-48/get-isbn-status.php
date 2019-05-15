<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/07

    you can run this using the URL:
		https://nrs-projects.humboldt.edu/~abc66/cs328/hw8/get-isbn-status.php

-->

<head>
    <title> ISBN Status </title>
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
		  
    <link href="bks.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<h1> Caught Read-Handed: ISBN Status </h1>
	
	<h2> Alex Childers - CS 328 </h2>
	
	<?php
	// has a username already been entered?
	if (! array_key_exists("username", $_POST))
	{
		// if not, generate a login form
		?>
		<form action="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>"
			  method="post">
			<fieldset>
				<legend> Request ISBN Status </legend>
				<fieldset>
					<legend> Select an ISBN </legend>
					<label for="isbn"> ISBN: </label>
					<select id="isbn" name="isbn" >
						<option value="0201106868"> 0201106868 </option>
						<option value="0201111160"> 0201111160 </option>
						<option value="0805367802"> 0805367802 </option>
						<option value="0805367829"> 0805367829 </option>
						<option value="0871507870"> 0871507870 </option>
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
	// log into Oracle and query one of the tables created by create-bks.sql
	else
	{
		// log in to Oracle
		$username = strip_tags($_POST["username"]); 
		$password = $_POST["password"]; 
		$conn = hsu_conn($username, $password); 
		
		// if we've reached here, we have successfully connected.
		
		// call is_on_order()
		$is_on_order_call = 
			"begin :on_order := bool_to_string(is_on_order(:isbn)); end;"; 
		$is_on_order_stmt = oci_parse($conn, $is_on_order_call);  
		
		// set input bind variable isbn
		$isbn = strip_tags($_POST["isbn"]); 
		oci_bind_by_name($is_on_order_stmt, ":isbn", $isbn);
		
		// set output bind variable on_order. fourth parameter is size
		oci_bind_by_name($is_on_order_stmt, ":on_order", $on_order, 5); 
		
		// execute function call
		oci_execute($is_on_order_stmt, OCI_DEFAULT); 
		
		// free statement
		oci_free_statement($is_on_order_stmt);
		
		// now call pending_order_needed in a similar manner
		$pending_order_call = "begin :has_pending_need := 
							bool_to_string(pending_order_needed(:isbn)); end;"; 
		$pending_order_stmt = oci_parse($conn, $pending_order_call); 
		
		oci_bind_by_name($pending_order_stmt, ":isbn", $isbn);
		
		// output bind variable has_pending_need. fourth parameter is size
		oci_bind_by_name($pending_order_stmt, ":has_pending_need", 
						 $has_pending_need, 5); 
		
		oci_execute($pending_order_stmt, OCI_DEFAULT); 
		oci_free_statement($pending_order_stmt);
		oci_close($conn);
		
		//now output results to web page
		?>
		<p> Status of ISBN <?= $isbn ?>: <br />
			<?= $isbn ?> is 
			<?php
			if($on_order === "FALSE")
			{
				?>
				not
				<?php
			}
			?>
			on order. <br />
			
			<?= $isbn ?>  
			<?php
			if($has_pending_need === "FALSE")
			{
				?>
				does not have
				<?php
			}
			else
			{
				?>
				has
				<?php
			}
			?>
			a pending order needed.
		</p>
		
		<p>
			<a href="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>">
				Request status of another ISBN.
			</a>
		</p>
		<?php
	}

	require_once("328footer.html"); 
?>