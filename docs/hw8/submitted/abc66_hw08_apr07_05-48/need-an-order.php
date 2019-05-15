<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/07

    you can run this using the URL:
		http://nrs-projects.humboldt.edu/~abc66/cs328/hw8/need-an-order.php

-->

<head>
    <title> Create "order needed" entry </title>
    <meta charset="utf-8" />
	
	<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        /* include required PHP functions */
        require_once("hsu_conn.php");
        require_once("need-order-form.php");
    ?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
	<link href="bks.css" type="text/css" rel="stylesheet" />
	
</head>

<body>
	<h1> Caught Read-Handed: Order Needed </h1>

	<h2> Alex Childers - CS 328 </h2>
	
	<?php
	// has a username already been entered?
	if (! array_key_exists("username", $_POST))
	{
		// if not, generate a login form
		need_order_form(); 
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
		
		// create call to insert_order_needed 
		$insert_order_needed_call = "begin insert_order_needed(:new_isbn,
															   :new_quantity);
									 end;"; 
									 
		$insert_order_needed_stmt = oci_parse($conn, $insert_order_needed_call); 
		
		// set bind variables representing arguments for insertion
		$new_isbn = strip_tags($_POST["isbn"]); 
		$new_quantity = strip_tags($_POST["quantity"]); 
		
		oci_bind_by_name($insert_order_needed_stmt, ":new_isbn", $new_isbn);
		oci_bind_by_name($insert_order_needed_stmt, ":new_quantity", 
			$new_quantity); 
		
		// run insert_order_needed()
		oci_execute($insert_order_needed_stmt, OCI_DEFAULT); 
		
		// commit changes
		oci_commit($conn); 
		
		// free statement
		oci_free_statement($insert_order_needed_stmt); 
		
		// give feedback
		// how many rows does the order_needed table now have?
		$quant_query = "select count(*)
						from order_needed"; 
		$quant_stmt = oci_parse($conn, $quant_query); 
		oci_execute($quant_stmt, OCI_DEFAULT); 
		oci_fetch($quant_stmt); 
		$num_order_needed_rows = oci_result($quant_stmt, "COUNT(*)"); 
		?>
		<p> Inserted order needed for <?= $new_quantity ?> copies of title with
			ISBN <?= $new_isbn ?>. 
		</p>
		<p>
			There are now <?= $num_order_needed_rows ?> orders needed in the
			<code> order_needed </code> table. 
		</p>
		<?php
			// free statement and close connection
			oci_free_statement($quant_stmt); 
			oci_close($conn); 
		?>
		
		<p>
			<a href="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>">
				Insert another order. 
			</a>
		</p>
		<?php
	}
	
	require_once("328footer.html"); 
?>