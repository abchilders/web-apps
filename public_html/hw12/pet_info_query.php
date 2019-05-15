<?php
    session_start();

/* 	Alex Childers
	Last modified: 2019/05/10
*/

/*	Builds an XML document based on the pet value in $_GET["choice"]
	Requires: hsu_conn_sess.php 
*/

?>
<?xml version="1.0" encoding="utf-8" ?>
<?php
    require_once("hsu_conn_sess.php");
?>

<pet_result>
<?php
    $conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);

    $userChoice = strip_tags($_GET["choice"]);
	
	$query_string = "select *
					 from 	pet
					 where	pet_id = :chosen_id"; 

    $query_stmt = oci_parse($conn, $query_string);
	oci_bind_by_name($query_stmt, ":chosen_id", $userChoice); 
    oci_execute($query_stmt, OCI_DEFAULT);
	
	// should only return one row since pet IDs are unique 
	oci_fetch($query_stmt); 
	$pet_id = oci_result($query_stmt, "PET_ID"); 
	$pet_name = oci_result($query_stmt, "PET_NAME"); 
	$pet_sex = oci_result($query_stmt, "SEX"); 
	$spayed_neutered = oci_result($query_stmt, "IS_SPAYED_NEUTERED"); 
	$birthday = oci_result($query_stmt, "BIRTHDAY"); 
	$pet_type = oci_result($query_stmt, "PET_TYPE"); 
	$owner_id = oci_result($query_stmt, "OWNER_ID"); 
?>
	
	
	<id><?= $pet_id ?></id>
	<name><?= $pet_name ?></name>
	<sex><?= $pet_sex ?></sex>
	<spayed_neutered><?= $spayed_neutered ?></spayed_neutered>
	<birthday><?= $birthday ?></birthday>
	<type><?= $pet_type ?></type>
	<owner_id><?= $owner_id ?></owner_id>
	
<?php
    oci_free_statement($query_stmt);
    oci_close($conn);
?>
</pet_result>