<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/03/31

    you can run this using the URL:
	http://nrs-projects.humboldt.edu/~abc66/cs328/hw7/328hw7-4.php

-->

<head>
    <title> HW 7-4 </title>
    <meta charset="utf-8" />
	
	<?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        require_once("328hw7-4-functs.php"); 
    ?>

    <!-- ADD CSS -->

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
		  
	<link href="328hw7-4.css" type="text/css" rel="stylesheet" />
</head>

<body>

	<h1> Homework 7-4: Comparing your preferences to the Childers' </h1>
	
	<h2> Alex Childers </h2>
	
	<?php
		if (! array_key_exists("submitted", $_POST))
		{
			make_form(); 
		}
		else
		{
			make_response(); 
		}
	?>

    <hr />

    <p>
        Validate by pasting .xhtml copy's URL into<br />
        <a href="https://html5.validator.nu/">
            https://html5.validator.nu/
        </a>
    </p>

    <p>
        <a href=
           "http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
            <img src="http://jigsaw.w3.org/css-validator/images/vcss"
                 alt="Valid CSS3!" height="31" width="88" />
        </a>
    </p>

</body>
</html>