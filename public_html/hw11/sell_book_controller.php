<?php
	session_start(); 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/05/01
	
	Uses: hsu_conn_sess.php, login_form.php, oracle-login-fieldset.html, 
		create_dropdown.php, show_books.php, confirm_sale.php, 
		sell_book.php, destroy_and_exit.php

    you can run this using the URL:
	https://nrs-projects.humboldt.edu/~abc66/cs328/hw11/sell_book_controller.php
-->

<head>
    <title> Sell a book </title>
    <meta charset="utf-8" />
	
	<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        /* include required PHP functions */
        require_once("hsu_conn_sess.php");
        require_once("login_form.php"); 
		require_once("create_dropdown.php"); 
		require_once("show_books.php"); 
		require_once("confirm_sale.php"); 
		require_once("sell_book.php"); 
		require_once("destroy_and_exit.php"); 
    ?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
	<link href="bks.css" type="text/css" rel="stylesheet" />
	
</head>

<body>
	<h1> Caught Read-Handed: Sell Book </h1>

	<h2> Alex Childers - CS 328 </h2>
	
	<?php
	
	// has a username already been entered?
	if (! array_key_exists("next-stage", $_SESSION))
	{
		// if not, generate a login form
		login_form(); 
		$_SESSION["next-stage"] = "select_book"; 
	}

	// if coming to book selection from login form, use form input to login,
	// create a drop-down of books, and show input for quantity 
	elseif($_SESSION["next-stage"] == "select_book")
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
		
		// now create form for selecting book and quantity 
		show_books(); 
		$_SESSION["next-stage"] = "confirm_sale"; 
	}
	
	// if coming to book selection after you've already sold another book OR
	// book sale was cancelled, 
	//	use saved username/password from $_SESSION to login,
	// create a drop-down of books, and show input for quantity  
	elseif((($_SESSION["next-stage"] == "book_sold") &&
		   (array_key_exists("sell_more", $_POST)))
			||
		   (($_SESSION["next-stage"] == "sell_or_cancel") &&
			(array_key_exists("cancel", $_POST))))
	{
		// get username and password from $_SESSION
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
		
		// now create form for selecting book and quantity 
		show_books($username, $password); 
		$_SESSION["next-stage"] = "confirm_sale"; 
	}
	
	// if you've sold a book and you want to log out, destroy session
	elseif(($_SESSION["next-stage"] == "book_sold") &&
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
	
	// if you've selected a book, confirm the sale 
	elseif($_SESSION["next-stage"] == "confirm_sale")
	{
		confirm_sale(); 
		$_SESSION["next-stage"] = "sell_or_cancel";
	}
	
	// once a sale has been confirmed, complete the transaction
	// and display confirmation 
	elseif($_SESSION["next-stage"] == "sell_or_cancel" && 
			(array_key_exists("confirm", $_POST)))
	{
		sell_book(); 
		$_SESSION["next-stage"] = "book_sold"; 
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
		$_SESSION["next-stage"] = "select_book"; 
	}
	
	require_once("328footer.html"); 
?>