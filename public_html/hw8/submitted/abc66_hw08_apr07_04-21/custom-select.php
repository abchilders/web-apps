<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/07

    you can run this using the URL:
	http://nrs-projects.humboldt.edu/~abc66/cs328/hw8/custom-select.php

-->

<head>
    <title> Loving Care Pet Boarding Select </title>
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
		<h1> Loving Care Pet Boarding - Selection Practice </h1>

		<h2> Alex Childers - CS 328 </h2>
	</div>
	
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
		// show a count of how many pets are enrolled in each section of 
		// daycare throughout the week of December 9, 2018 - December 15, 2018,
		// as well as relevant enrollment information.
		$daycare_query_str = 
			"select 	date_of_daycare, daycare_category, count(*) enrollments,
						substr(lpad(to_char(min(start_time)), 4, '0'), 1, 2)
							|| ':' ||
							substr(lpad(to_char(min(start_time)), 4, '0'), 3)
							earliest_dog_arrival,
						substr(lpad(to_char(max(end_time)), 4, '0'), 1, 2)
							|| ':' ||
							substr(lpad(to_char(max(end_time)), 4, '0'), 3)
							latest_dog_departure
			from    	daycare_enrollment de join doggy_daycare dd
                        on de.section_id = dd.section_id
			where		date_of_daycare between '09-DEC-2018' and '15-DEC-2018'
			group by    date_of_daycare, daycare_category
			order by    date_of_daycare, daycare_category";
							
		$daycare_stmt = oci_parse($conn, $daycare_query_str); 
		
		oci_execute($daycare_stmt, OCI_DEFAULT); 
		
		// create a table to display the query results
		?>
		
		<table>
		<caption> 
			Daycare Enrollments for December 9, 2018 to December 15, 2018 
		</caption> 
		<tr>
			<th scope="col"> Date </th>
			<th scope="col"> Category </th>
			<th scope="col"> Number of enrollments </th>
			<th scope="col"> Earliest arrival </th>
			<th scope="col"> Latest departure </th>
		</tr>
		
		<?php
		while (oci_fetch($daycare_stmt))
		{
			$curr_date = oci_result($daycare_stmt, "DATE_OF_DAYCARE");
			$curr_category = oci_result($daycare_stmt, "DAYCARE_CATEGORY");
			$curr_enrollments = oci_result($daycare_stmt, "ENROLLMENTS"); 
			$curr_early_arr = 
				oci_result($daycare_stmt, "EARLIEST_DOG_ARRIVAL"); 
			$curr_latest_dep = 
				oci_result($daycare_stmt, "LATEST_DOG_DEPARTURE"); 
			
			// create a new table row for each resulting row in the query
			?>
			
			<tr>
				<td> <?= $curr_date ?> </td>
				<td> <?= $curr_category ?> </td>
				<td class="numeric"> <?= $curr_enrollments ?> </td>
				<td> <?= $curr_early_arr ?> </td>
				<td> <?= $curr_latest_dep ?> </td>
			</tr>
			<?php
		}
		?>
		</table>
		
		<?php
		// free statement objects and close connection
		oci_free_statement($daycare_stmt);
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

