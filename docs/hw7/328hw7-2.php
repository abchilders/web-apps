<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/03/31

    you can run this using the URL: 
	http://nrs-projects.humboldt.edu/~abc66/cs328/hw7/328hw7-2.php

-->

<head>
    <title> HW 7-2 </title>
    <meta charset="utf-8" />
	
	<?php
		ini_set('display_errors', 1); 
		error_reporting(E_ALL); 
	?>

    <link href="http://nrs-projects.humboldt.edu/~abc66/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>

	<h1> Homework 7 Problem 2 </h1>
	
	<h2> Alex Childers </h2>

	<h2> Practicing with rand(1, 32) inclusive </h2>

	<ul>
		<?php
			for ($i = 0; $i < 5; $i++)
			{
				?>
				<li> <?= rand(1, 32) ?> </li>
				<?php
			}
		?>
	</ul> 
	
	<h2> Practicing with sprintf() </h2>

	<p>
		Pi to 2 fractional places, with some extra formatting, is: 
		<?= sprintf("%+06.2f", pi()) ?> <br />
		
		And showing 439932 in scientific notation, with a string thrown in there: 
		<?= sprintf("%'.15s = %.5e", "max level", 439932) ?>
	</p>
	
	<h2> Practicing with an array containing 10 elements and a foreach loop </h2>
	
	<?php
		$mario_kart_stages = array("Block Plaza", "Delfino Pier", 
			"Funky Stadium", "Chain Chomp Wheel", "Thomp Desert",
			"SNES Battle Course 4", "GBA Battle Course 3", "N64 Skyscraper", 
			"GCN Cookie Land", "DS Twilight House"); 
	?>
	
	<ul>
		<?php
			foreach ($mario_kart_stages as $stage)
			{
			?>
				<li> <?= $stage ?> </li>
			<?php
			}
		?>
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

