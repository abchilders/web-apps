<?php
    session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Rawan Almakhloog, Alex Childers, Sthephany Ponce
    last modified: 2019/04/12

    you can run this using the URL: 
		http://nrs-projects.humboldt.edu/~abc66/cs328/lab11/pub-titles.php

-->

<head>
    <title> Lab 11 </title>
    <meta charset="utf-8" />
	
	<?php
		require_once("pub-functs.php"); 
		require_once("hsu_conn_sess.php"); 
		require_once("destroy_and_exit.php"); 
	?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>
	<h1> Lab 11 </h1>
	
	<?php
	// initially, we need to create a login form 
	if ((! array_key_exists('next-stage', $_SESSION))
		or ($_SESSION['next-stage'] == "create_login"))
    {
        create_login();
        $_SESSION['next-stage'] = "create_pub_dropdown";
    }
	
	// when user sends login info, create a dropdown of publishers 
	elseif ($_SESSION['next-stage'] == "create_pub_dropdown")
    {
        create_pub_dropdown();
        $_SESSION['next-stage'] = "get_pub_titles";
    }
	
	elseif ($_SESSION['next-stage'] == "get_pub_titles")
	{
		get_pub_titles(); 
		$_SESSION['next-stage'] = "create_login"; 
	}

require_once("328footer.html"); 	
?>

