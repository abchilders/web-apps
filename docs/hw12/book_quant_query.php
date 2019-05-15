<?php 
/* 	Alex Childers
	Last modified: 2019/05/10
*/

/*
	builds a small XML document to query quantity based on value in 
		$_GET["choice"]
	
	requires: hsu_conn_sess.php 
*/
?>

<?xml version="1.0" encoding="utf-8" ?>
<?php
    require_once("hsu_conn_sess.php");
?>
<results>
<?php
    $conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);

    $user_choice = strip_tags($_GET["choice"]);

    $query_string = "select qty_on_hand
					 from 	title
					 where	isbn = :chosen_isbn"; 

    $query_stmt = oci_parse($conn, $query_string);
	oci_bind_by_name($query_string, ":chosen_isbn", $user_choice); 
    oci_execute($query_stmt, OCI_DEFAULT);

	// should only return one row-- ISBNs are unique 
    oci_fetch($query_stmt); 
?>
<quantity><?= oci_result($query_stmt, "QTY_ON_HAND") ?></quantity>
<?php
    oci_free_statement($query_stmt);
    oci_close($conn);
?>
</results>
