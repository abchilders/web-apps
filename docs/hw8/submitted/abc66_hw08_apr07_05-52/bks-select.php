<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/06

    you can run this using the URL:
	http://nrs-projects.humboldt.edu/~abc66/cs328/hw8/bks-select.php

-->

<head>
    <title> Bookstore Select </title>
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
	<h1> Caught Read-Handed: Bookstore Selection </h1>

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
		<?php
			require_once("oracle-login-fieldset.html"); 
		?>
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
		// query the title & publisher table
		$title_query_str = "(select 	pub_name, count(*)
							 from		publisher p join title t
										on p.pub_id = t.pub_id
							 group by	pub_name)
							union
							(select 	pub_name, 0
							 from		publisher p
							 where		not exists
										(select 'a'
										 from	title t
										 where p.pub_id = t.pub_id))
							order by	pub_name";
							
		$title_stmt = oci_parse($conn, $title_query_str); 
		
		oci_execute($title_stmt, OCI_DEFAULT); 
		
		// create a table to display the query results
		?>
		
		<table>
		<caption> 
			How many titles each publisher has in our bookstore 
		</caption> 
		<tr>
			<th scope="col"> Publisher Name </th>
			<th scope="col"> Quantity of titles sold in store </th>
		</tr>
		
		<?php
		while (oci_fetch($title_stmt))
		{
			$curr_pub_name = oci_result($title_stmt, "PUB_NAME");
			$curr_quant_titles = oci_result($title_stmt, "COUNT(*)"); 
			
			// create a new table row for each resulting row in the query
			?>
			
			<tr>
				<td> <?= $curr_pub_name ?> </td>
				<td> <?= $curr_quant_titles ?> </td>
			</tr>
			<?php
		}
		?>
		</table>
		
		<?php
		// free statement objects and close connection
		oci_free_statement($title_stmt);
		oci_close($conn); 
		
		?>
		
		<p>
			<a href="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>">
				Try again?
			</a>
		</p>
		<?php
	}
	
	require_once("328footer.html"); 
?>

