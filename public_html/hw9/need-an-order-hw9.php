<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/24
	
	Uses: hsu_conn_sess.php, login_form.php, destroy_and_exit.php, 
		get_order_info.php, create_dropdown.php, insert_order.php,
		328footer.html

    you can run this using the URL:
		https://nrs-projects.humboldt.edu/~abc66/cs328/hw9/need-an-order-hw9.php
-->

<head>
    <title> Create "order needed" entry </title>
    <meta charset="utf-8" />
	
	<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        /* include required PHP functions */
        require_once("hsu_conn_sess.php");
        require_once("login_form.php");
		require_once("get_order_info.php"); 
		require_once("create_dropdown.php"); 
		require_once("insert_order.php"); 
		require_once("destroy_and_exit.php"); 
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
	if (! array_key_exists("next-stage", $_SESSION))
	{
		// if not, generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "get_order_info"; 
	}

	// log into Oracle and create a drop-down of isbns and titles, plus
	// a place to input order quantity
	elseif ($_SESSION["next-stage"] == "get_order_info")
	{
		get_order_info(); 
		$_SESSION["next-stage"] = "insert_order"; 
	}

	// then, insert a new order needed
	elseif($_SESSION["next-stage"] == "insert_order")
	{
		insert_order(); 
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
		$_SESSION["next-stage"] = "get_order_info"; 
	}
	
	require_once("328footer.html"); 
?>