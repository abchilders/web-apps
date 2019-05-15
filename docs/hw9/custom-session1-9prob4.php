<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/24

    you can run this using the URL:
	https://nrs-projects.humboldt.edu/~abc66/cs328/hw9/custom-session1-9prob4.php
	
	Uses: hsu_conn_sess.php, login_form.php, destroy_and_exit.php, 
		select_owner-9prob4.php, add_owner_info-9prob4.php,
		328footer.html
		
	NOTE!!! Make sure to run 325populate.sql twice, due to an odd bug related
	to sequence generation that I still haven't solved. Otherwise, owner IDs 
	will not be consistent across all tables in the database.
	
	This PHP file asks the user to enter their Oracle username and password. 
	Upon logging in, the user will select a owner from the database, and 
	input any contact information they wish to add. This application then shows
	the updated information for this owner and allows the user to keep adding 
	info as desired.
-->

<head>
    <title> Add Owner Contact Info </title>
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
		require_once("select_owner-9prob4.php"); 
		require_once("add_owner_info-9prob4.php"); 
	?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
    <link href="custom.css" type="text/css" rel="stylesheet" />
	<link href="custom-session1.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div class="header">
		<h1> Loving Care Pet Boarding: Add Owner Contact Info </h1>
		
		<h2> Alex Childers - CS 328 </h2>
	</div>
	
	<?php
	// has a username already been entered?
	if (! array_key_exists("next-stage", $_SESSION))
	{
		// if not, generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "select_owner"; 
	}

	// if coming to owner selection from login form, use form input to login,
	// create a drop-down of owners, and show inputs for contact information 
	elseif($_SESSION["next-stage"] == "select_owner")
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
		
		// now create form for selecting owner 
		select_owner($username, $password); 
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
	
	// if you've added owner info and you want to log out, destroy session
	elseif(($_SESSION["next-stage"] == "insert_done") &&
		   (array_key_exists("logout", $_POST)))
	{
		session_destroy();

        ?>
        <p> You have been logged out.
            <a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            Start over? </a> 
        </p>
        <?php
	}
	
	// if you've selected an owner but haven't inserted the new contact
	// info yet, do so and show the results now
	elseif($_SESSION["next-stage"] == "selected_owner")
	{
		add_owner_info(); 
		$_SESSION["next-stage"] = "insert_done";
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
		$_SESSION["next-stage"] = "select_owner"; 
	}
	
	require_once("328footer.html"); 
?>