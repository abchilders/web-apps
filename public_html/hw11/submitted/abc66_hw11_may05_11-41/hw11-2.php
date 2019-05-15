<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers 
    last modified: 2019/05/05

    you can run this using the URL:
	https://nrs-projects.humboldt.edu/~abc66/cs328/hw11/hw11-2.php

-->

<head>
    <title> HW 11-2: Get JSON </title>
    <meta charset="utf-8" />

    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>
	<h1> Decoding JSON file in PHP </h1>
	<h2> Alex Childers - CS 328 </h2>
	
<?php
	// load JSON 
	$petJSONString = file_get_contents("hw11-2.json"); 
	$petObject = json_decode($petJSONString); 
	
	// store contents in local variables 
	$id = $petObject->{"id"}; 
	$name = $petObject->{"name"}; 
	$sex = $petObject->{"sex"}; 
	$is_spayed_neutered = $petObject->{"is_spayed_neutered"}; 
	$birthday = $petObject->{"birthday"}; 
	$type = $petObject->{"type"}; 
	$owner_id = $petObject->{"owner_id"}; 
?>
	<p> This pet's attributes: </p> 
	<ul>
		<li> $petObject->{"id"}: <?= $id ?> </li>
		<li> $petObject->{"name"}: <?= $name ?> </li>
		<li> $petObject->{"sex"}: <?= $sex ?> </li>
		<li> $petObject->{"is_spayed_neutered"}: <?= $is_spayed_neutered ?> </li>
		<li> $petObject->{"birthday"}: <?= $birthday ?> </li>
		<li> $petObject->{"type"}: <?= $type ?> </li>
		<li> $petObject->{"owner_id"}: <?= $owner_id ?> </li>
	</ul>

<?php
	require_once("328footer.html"); 
?>