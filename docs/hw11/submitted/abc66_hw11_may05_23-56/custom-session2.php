<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/05/05

    you can run this using the URL:
	https://nrs-projects.humboldt.edu/~abc66/cs328/hw11/custom-session2.php
		
	Uses: hsu_conn_sess.php, oracle_login_fieldset.html, login_form.php, 
		select_action.php, select_volunteer.php, select_owner-9prob4.php,
		add_owner_info-9prob4.php, update_pet.php, destroy_and_exit.php, 
		328footer.html
		
	NOTE!!! Make sure to run 325populate.sql twice, due to an odd bug related
	to sequence generation that I still haven't solved. Otherwise, owner IDs 
	will not be consistent across all tables in the database.
	
	This PHP file asks the user to enter their Oracle username and password. 
	Upon logging in, the user will select what action they want to perform
	on the database. They will then be allowed to perform that action as many
	times as they wish until they choose another action or log out. 
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
		require_once("select_volunteer.php");
		require_once("select_owner-9prob4.php"); 
		require_once("add_owner_info-9prob4.php"); 
		require_once("destroy_and_exit.php");
		require_once("update_pet.php"); 
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
	// does the $_SESSION array lack a username? or, have we just logged out?
	if (! array_key_exists("next-stage", $_SESSION) 
		|| array_key_exists("logout", $_POST) )
	{
		if( array_key_exists("logout", $_POST) )
		{
			// log out and display message
			session_destroy();
			session_start(); 
			session_regenerate_id(TRUE); 			
			?>
			<p> You have been successfully logged out. </p> 
			<?php
		}
		// generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "select_action"; 
	}
	
	// if coming from login form, log into Oracle and display possible actions 
	// for the user  
	elseif($_SESSION["next-stage"] === "select_action")
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
	}
	
	// the user wants to delete a volunteer
	elseif( ($_SESSION["next-stage"] === "selected_action") 
			&& ($_POST["action"] === "delete_vol") )
	{
		select_volunteer(); 
		
		// this is currently a stub and will lead to an error and/or
		// logout if you try to continue from here
		session_destroy(); 
	}
	
	// START LOGICAL BLOCK: the user wants to add owner contact information
	// right after selecting action 
	elseif( ($_SESSION["next-stage"] === "selected_action") 
			&& ($_POST["action"] === "add_owner_info") )
	{
		select_owner($_SESSION["username"], $_SESSION["password"]); 
		$_SESSION["next-stage"] = "selected_owner"; 
	}
	
	// if coming to owner selection after you've already added info for 
	// an owner, use saved username/password from $_SESSION to login,
	// create a drop-down of owners, and show inputs for contact information 
	elseif(($_SESSION["next-stage"] == "insert_done") &&
		   (array_key_exists("add_more", $_POST)))
	{
		// get username and password from $_SESSION
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
		
		// now create form for selecting owner 
		select_owner($username, $password); 
		$_SESSION["next-stage"] = "selected_owner"; 
	}
	
	// if you've selected an owner but haven't inserted the new contact
	// info yet, do so and show the results now
	elseif($_SESSION["next-stage"] == "selected_owner")
	{
		add_owner_info(); 
		$_SESSION["next-stage"] = "insert_done";
	}
	// END LOGICAL BLOCK: adding owner contact information 
	
	// the user wants to update pet information 
	elseif( ($_SESSION["next-stage"] === "selected_action") 
			&& ($_POST["action"] === "update_pet") )
	{
		update_pet(); 
		
		// this is currently a stub and will lead to an error if you 
		// attempt to continue from here 
		session_destroy(); 
	}
	
	// error handling 
	else
	{
		?>
		<p> An error occurred. Please try again. </p> 
		<?php
		session_destroy(); 
		session_start(); 
		session_regenerate_id(TRUE); 
		
		// create a new login form 
		login_form(); 
		$_SESSION["next-stage"] = "select_action"; 
	}
	
	require_once("328footer.html"); 
?>