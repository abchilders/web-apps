<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/04/26

    you can run this using the URL:
		https://nrs-projects.humboldt.edu/~abc66/cs328/hw10/number-fun.php

-->

<head>
    <title> Napkin Math </title>
    <meta charset="utf-8" />

    <link href="https://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		
</head>

<body>
	<h1> Calculate total napkin usage </h1> 
	<h2> Alex Childers - CS 328 </h2> 
	
	<h2> Calculate your napkin usage </h2>
	
	<p> Given a fully unfolded napkin, 
	<a href="https://abchilders.github.io/napkin-math.xhtml">how much of its 
		surface area can you use</a> if you fold it in half every time you've
		used one side? 
	</p>
	
	<p> 
		<label for="length"> Napkin length: </label>
		<input type="number" id="length" name="length" step="any" 
			required="required"/>
		
		<label for="width"> Napkin width: </label>
		<input type="number" id="width" name="width" step="any" 
			required="required"/> 
		
		<label for="units"> Units: </label>
		<select name="units">
			<option value="in"> inches </option> 
			<option value="cm"> centimeters </option> 
		</select>
		
		<button id="calculate"> Calculate maximum usage </button> 
	</p>

<?php
	require_once("328footer.html"); 
?>