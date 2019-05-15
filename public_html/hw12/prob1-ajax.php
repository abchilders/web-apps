<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/05/08
	
	you can run this using the URL: 
	http://nrs-projects.humboldt.edu/~abc66/cs328/hw12/prob1-ajax.php
-->

<head>
    <title> Problem 1: Ominous Ajax </title>
    <meta charset="utf-8" />

    <link href="https://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />

    <script src="prob1-ajax.js" type="text/javascript"
            async="async">
    </script>
</head>

<body>

   <p> <strong> [warning: this page will not behave as it should if
       JavaScript is disabled] </strong>
   </p>

    <h1> Trying Ajax, Ominously </h1>
	
	<h2> Alex Childers - CS 328 </h2>
	
	<button id="positive"> Ominous positivity </button> 
	<button id="neutral"> Ominous neutrality </button>
	<button id="negative"> Ominous negativity </button> 

    <h2> Your forecast: </h2>
	<p id="forecast"></p> 

<?php
    require_once("328footer.html");
?>