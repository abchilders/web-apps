<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/22

    you can run this using the URL:
		https://nrs-projects.humboldt.edu/~abc66/cs328/hw9/custom-session1.php
		
	NOTE!!! Make sure to run 325populate.sql twice, due to an odd bug related
	to sequence generation that I still haven't solved. Otherwise, worker and 
	volunteer IDs will not be consistent across all tables in the database.
	
	This PHP file asks the user to enter their Oracle username and password. 
	Upon logging in, the user will select a volunteer to delete from the 
	database. This application then deletes said volunteer from all applicable
	tables and ends the session. 
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
        require_once("hsu_conn_sess.php");
		require_once("login_form.php"); 
		require_once("destroy_and_exit.php"); 
		require_once("select_volunteer.php"); 
		require_once("delete_volunteer.php"); 
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
	if (! array_key_exists("next-stage", $_SESSION))
	{
		// if not, generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "select_volunteer"; 
	}
	
	// if a username already exists, respond to the form--
	// log into Oracle and create a drop-down of volunteers and their IDs 
	elseif($_SESSION["next-stage"] == "select_volunteer")
	{
		select_volunteer(); 
		$_SESSION["next-stage"] = "delete_volunteer"; 
	}
	elseif($_SESSION["next-stage"] == "delete_volunteer")
	{
		delete_volunteer(); 
		session_destroy(); 
	}
	
	// error handling 
	else
	{
		?>
		<p> An error occurred. Please try again. </p> 
		<?php
		session_destroy(); 
		session_regenerate_id(TRUE); 
		session_start(); 
		
		// create a new login form 
		login_form(); 
		$_SESSION["next-stage"] = "select_volunteer"; 
	}
	
	require_once("328footer.html"); 
?>