<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/24

    you can run this using the URL:
		https://nrs-projects.humboldt.edu/~abc66/cs328/hw9/get-isbn-status-hw9.php
		
	Uses: hsu_conn_sess.php, login_form.php, destroy_and_exit.php, 
		get_isbn.php, create_dropdown.php, check_order_status.php, 
		328footer.html
		
	This PHP file asks the user to log in and select an ISBN. It displays
	whether this ISBN is on order or not, and if it has a pending order needed.
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

	/* include required PHP functions */
        require_once("hsu_conn_sess.php");
        require_once("login_form.php");
		require_once("get_isbn.php"); 
		require_once("create_dropdown.php"); 
		require_once("check_order_status.php"); 
		require_once("destroy_and_exit.php"); 
	?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
    <link href="bks.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<h1> Caught Read-Handed: ISBN Status </h1>
	
	<h2> Alex Childers - CS 328 </h2>
	
	<?php
	if (! array_key_exists("next-stage", $_SESSION))
	{
		// if not, generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "get_isbn"; 
	}
	
	// log into Oracle and create a drop-down of isbns and titles
	elseif ($_SESSION["next-stage"] == "get_isbn")
	{
		get_isbn(); 
		$_SESSION["next-stage"] = "check_order_status"; 
	}
	elseif($_SESSION["next-stage"] == "check_order_status")
	{
		check_order_status(); 
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
		$_SESSION["next-stage"] = "get_isbn"; 
	}

	require_once("328footer.html"); 
?>