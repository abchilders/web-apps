<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    by: Alex Childers
    last modified: 2019/03/31

    you can run this using the URL:
	http://nrs-projects.humboldt.edu/~abc66/cs328/hw7/328hw7-3.php

-->

<head>
    <title> HW 7-3: Emoticon Generator </title>
    <meta charset="utf-8" />
	
	<?php
		ini_set('display_errors', 1); 
		error_reporting(E_ALL); 
	?>

    <link href="http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
          type="text/css" rel="stylesheet" />
</head>

<body>

	<h1> Homework 7 Problem 3 </h1>
	
	<h2> Alex Childers </h2>
	
	<?php
		if (! array_key_exists("submitted", $_POST))
		{
			// create a form
	?>
			<form method="post" 
				action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
				<fieldset>
					<legend> Generate spam that will make your friends mute 
						you 
					</legend>
					 
					<label for="user_word"> 
						Type an emoticon or word that you want to spam: 
					</label>
					<input type="text" id="user_word" name="user_word" 
						required="required"/>
						
					<br />
					
					<label for="reps">
						How many times do you want to print this?
					</label>
					<input type="number" id="reps" name="reps" 
						required="required"/>
					
				</fieldset>
				
				<!-- sends submitted=Submit when the form has been filled -->
				<input type="submit" name="submitted" value="Submit" />
			</form>
	<?php 
		}
		else
		{
			// respond to the form by printing the requested emoticon however
			// many times the user specified 
	?>
			<p> Copy and paste the following block of text, then send to all 
				your friends in rapid succession. Watch your friend quantity 
				drop at the speed of light. GLHF! 
			</p>
			
			<p>
				<a href="http://nrs-projects.humboldt.edu/~abc66/cs328/hw7/328hw7-3.php">
					Do it again? </a>
			</p>
			
			<hr />
			
			<p>
			<?php
				$word = htmlspecialchars($_POST["user_word"]); 
				
				for ($i = 0; $i < strip_tags($_POST["reps"]); $i++)
				{
			?>
					<?= $word . " " ?>
			<?php
				}
			?>
			</p>
	<?php
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