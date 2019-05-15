<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">


<!--
    by: Jakob Fletcher and Alex Childers
    last modified: 3/15/2019

    you can run this using the URL: nrs-projects.humboldt.edu/~jdf435/lab8/lab8-response.php

-->

<head>
    <title> Lab 8 </title>
    <meta charset="utf-8" />

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>

    <?php
       ini_set('display_errors', 1);
       error_reporting(E_ALL);
    ?>

    <ul>
	<?php foreach(array_keys($_GET) as $next_form_key)
	{
	?>
	  <li><?=htmlspecialchars($next_form_key)?>: <?= htmlspecialchars($_GET[$next_form_key])?></li>
	<?php
	}
	?>
	<p>Iterating using array keys</p>
	<hr />

	<li>
	   last name: <?= htmlspecialchars($_GET["lastname"])?>
		
	</li>
	<li>
           age: <?= htmlspecialchars($_GET["age"])?>
	</li>

	<li>
	   state: <?= htmlspecialchars($_GET["state"])?>
	</li>
	<li>
	   secret word: <?= htmlspecialchars($_GET["secret_word"])?>
	</li>
	<li>
	   intro: <?= htmlspecialchars($_GET["intro"])?>
	</li>
	<li>
	   ice cream flavor: <?= htmlspecialchars($_GET["ice_cream_flavor"])?>
	</li>
	   <?php

		if(array_key_exists("bike", $_GET)){
			?><li>Bike: <?= htmlspecialchars($_GET["bike"])?> </li>
			<?php
		}
		if(array_key_exists("car", $_GET)){ 
                        ?><li>Car: <?= htmlspecialchars($_GET["car"])?> </li>
			<?php
                }
		if(array_key_exists("skateboard", $_GET)){ 
                        ?><li>Skateboard: <?= htmlspecialchars($_GET["skateboard"])?> </li>
			<?php
                }
		if(array_key_exists("horse", $_GET)){ 
                        ?><li>Horse: <?= htmlspecialchars($_GET["horse"])?> </li>
			<?php
                }

	   ?>
	<p>Access get array directly</p>
    </ul>

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


