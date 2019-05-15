<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/05/01

    you can run this using the URL:
	https://nrs-projects.humboldt.edu/~abc66/cs328/hw11/hw11-1.php
	
	Uses: 328footer.html
-->

<head>
    <title> HW 11-1: Get XML </title>
    <meta charset="utf-8" />

    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>
	<h1> Decoding XML file in PHP </h1> 
	
	<h2> Alex Childers - CS 328 </h2>
	
	<?php
		// load xml file 
		$petXml = simplexml_load_file("hw11-1.xml"); 
		
		// store contents in local variables 
		$id = $petXml->id; 
		$name = $petXml->name;
		$sex = $petXml->sex;
		$is_spayed_neutered = $petXml->is_spayed_neutered;
		$birthday = $petXml->birthday;
		$type = $petXml->type;
		$owner_id = $petXml->owner_id;
	?>
	
	<p> This pet's attributes: </p>
	<ul>
		<li> $petXml->id: <?= $id ?> </li>
		<li> $petXml->name: <?= $name ?> </li>
		<li> $petXml->sex: <?= $sex ?> </li>
		<li> $petXml->is_spayed_neutered: <?= $is_spayed_neutered ?> </li>
		<li> $petXml->birthday: <?= $birthday ?> </li>
		<li> $petXml->type: <?= $type ?> </li>
		<li> $petXml->owner_id: <?= $owner_id ?> </li>
	</ul>
	
<?php
	require_once("328footer.html"); 
?>

