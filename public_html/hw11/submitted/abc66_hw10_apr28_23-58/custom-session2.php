<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/28

    you can run this using the URL:
	https://nrs-projects.humboldt.edu/~abc66/cs328/hw10/custom-session2.php
		
	Uses: hsu_conn_sess.php, oracle_login_fieldset.html, login_form.php, 
		select_action.php, destroy_and_exit.php, 328footer.html
		
	NOTE!!! Make sure to run 325populate.sql twice, due to an odd bug related
	to sequence generation that I still haven't solved. Otherwise, owner IDs 
	will not be consistent across all tables in the database.
	
	This PHP file asks the user to enter their Oracle username and password. 
	Upon logging in, the user will select what action they want to perform
	on the database. (NOTE TO SELF!!! AND THEN WHAT???)
	
	TO DO: CONTINUE WORKING OUT FSM TO MAP THIS DOCUMENT 
-->

<head>
    <title> Menu </title>
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
		require_once("select_action.php"); 
		require_once("destroy_and_exit.php"); 
	?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
    <link href="custom.css" type="text/css" rel="stylesheet" />
	<link href="custom-session1.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div class="header">
		<h1> Loving Care Pet Boarding: Menu </h1>
		
		<h2> Alex Childers - CS 328 </h2>
	</div>
	
	<?php
	// has a username already been entered?
	if (! array_key_exists("next-stage", $_SESSION))
	{
		// if not, generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "select_action"; 
	}
	
	// if coming from login form, log into Oracle and display possible actions 
	// for the user  
	elseif($_SESSION["next-stage"] == "select_action")
	{
		// get username and password from login form 
		if ( (! array_key_exists("username", $_POST)) or
             (trim($_POST["username"]) == "") or
             (! isset($_POST["username"])) )
        {
            destroy_and_exit("No username entered.");
        }

        if ( (! array_key_exists("password", $_POST)) or
             (trim($_POST["password"]) == "") or
             (! isset($_POST["password"])) )
        {
            destroy_and_exit("No password entered.");
        }

        $username = strip_tags($_POST["username"]);
        $password = $_POST['password'];

        // save username and password for future use 

        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
		
		// now show a selection of actions  
		select_action($username, $password); 
		$_SESSION["next-stage"] = "selected_action"; 
		
		// temporary: destroying session here for stub reasons
		session_destroy(); 
		
		// then later, determine next stage based on user choice 
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
		$_SESSION["next-stage"] = "select_action"; 
	}
	
	require_once("328footer.html"); 
?>