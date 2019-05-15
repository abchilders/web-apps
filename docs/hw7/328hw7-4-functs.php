<?php

/* 	Alex Childers
	Last modified: 2019/03/31
*/

/* 	Function: make_form
	Expects nothing; returns nothing
	Side effects: Creates a an HTML form that asks the user to describe their
		preferences from a given set of choices.
*/
function make_form()
{
?>
	<form method="post"
		  action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>" >
		  
		<fieldset>
			<legend> About you	</legend>
			
			<label for="name"> What is your name? </label>
			<input type="text" id="name" name="name" />
			
			<fieldset>
				<legend>
					Have you listened to any of the following genres of music
					lately?
				</legend>
				<input type="checkbox" id="ind_folk" name="ind_folk" />
				<label for="ind_rk"> Chill/indie folk </label>
				<br />
				
				<input type="checkbox" id="jazz" name="jazz" />
				<label for="ind_rk"> Jazz </label>
				<br />
				
				<input type="checkbox" id="electr" name="electr" />
				<label for="ind_rk"> Electronica </label>
				<br />
				
				<input type="checkbox" id="ind_pr" name="ind_pr" />
				<label for="ind_rk"> Indie pop rock </label>
				<br />
			</fieldset>
			
			<fieldset>
				<legend> Out of the following colors, which do you like the 
					most?
				</legend>
				<input type="radio" id="burgundy" name="color" 
					   value="Burgundy"/>
				<label for="burgundy"> Burgundy </label>
				<br />
				
				<input type="radio" id="indigo" name="color" 
					   value = "Deep indigo"/>
				<label for="indigo"> Deep indigo </label>
				<br />
				
				<input type="radio" id="lavender" name="color" 
					   value="Lavender"/>
				<label for="lavender"> Lavender </label>
				<br />
				
				<input type="radio" id="blue" name="color" value="Blue" />
				<label for="blue"> Blue </label><br />
			</fieldset>
			
			<label for="egg_want"> On a scale of 1 to 10, how much do you want
				a poached egg right now? (1 = not at all, 10 = want it a LOT)
			</label> <br />
			<input id="egg_want" name="egg_want" type="number" min="1" 
				   max="10" required="required" />
			
			<fieldset>
				<legend> Which emoji do you dislike most?
				</legend>
				
				<input type="radio" id="tongue" name="worst_emoji" 
				       value="tongue" />
				<label for="tongue">
					<img src="https://i.pinimg.com/originals/6b/bc/ae/6bbcaedf7119d5ab653385feae56d322.png"
						 alt="stuck out tongue with winking eye emoji" 
						 width="50" height="50"/>
				</label>
				<br />
				
				<input type="radio" id="hug" name="worst_emoji" value="hug" />
				<label for="hug">
					<img src="https://clipart.info/images/ccovers/1496184257Hugging-Emoji-png-transparent-Icon.png"
						 alt="hugging emoji" width="50" height="50"/>
				</label>
				<br />
				
				<input type="radio" id="all" name="worst_emoji" value="all" />
				<label for="all"> I hate all emojis equally </label>
				<br />
			</fieldset>
			
			<input type="submit" name="submitted" value="Submit" />
		</fieldset>
	</form>
<?php
}

/* 	Function: make_response
	Expects nothing, returns nothing
	Side effects: shows your preferences compared to those of the Childers	
		siblings
*/
function make_response()
{
	// assemble user responses
	$name = strip_tags($_POST["name"]); 
	
	$music = ""; 
	
	if(array_key_exists("ind_folk", $_POST))
	{
		$music .= nl2br("Chill/indie folk \r\n"); 
	}
	if(array_key_exists("jazz", $_POST))
	{
		$music .= nl2br("Jazz \r\n");
	}
	if(array_key_exists("electr", $_POST))
	{
		$music .= nl2br("Electronica \r\n"); 
	}
	if(array_key_exists("ind_pr", $_POST))
	{
		$music .= nl2br("Indie pop rock \r\n"); 
	}
	
	if(array_key_exists("color", $_POST))
	{
		$color = strip_tags($_POST["color"]); 
	}
	else
	{
		$color = "No color selected"; 
	}
	
	$egg_desire = strip_tags($_POST["egg_want"]); 
	
	// will print image in table later
	if(array_key_exists("worst_emoji", $_POST))
	{
		$worst_emoji = strip_tags($_POST["worst_emoji"]); 
	}
	else
	{
		$worst_emoji = "none"; 
	}
	
	// create a table of all Childers siblings' and user's responses
?>
	<table>
		<caption> Your preferences compared to the Childers's </caption>
		<tr id="user_prefs">
			<th scope="col"> Name
			<th scope="col"> Music listened to </th>
			<th scope="col"> Favorite color </th>
			<th scope="col"> Poached egg desire (1-10) </th>
			<th scope="col"> Least favorite emoji </th>
		</tr>
		<tr>
			<td> <?= $name ?> </td>
			<td> <?= $music ?> </td>
			<td> <?= $color ?> </td>
			<td> <?= $egg_desire ?> </td> 
			<td> 
				<?php
					if($worst_emoji === "tongue")
					{
				?>
						<img src="https://i.pinimg.com/originals/6b/bc/ae/6bbcaedf7119d5ab653385feae56d322.png"
						 alt="stuck out tongue with winking eye emoji" 
						 width="50" height="50"/>
				<?php
					}
					elseif($worst_emoji === "hug")
					{
				?>
						<img src="https://clipart.info/images/ccovers/1496184257Hugging-Emoji-png-transparent-Icon.png"
						 alt="hugging emoji" width="50" height="50"/>
				<?php
					}
					elseif($worst_emoji === "none")
					{
				?>
						No emoji selected
				<?php
					}
					else
					{
				?>
						All emojis
				<?php
					}
				?>
			</td>
		</tr>
		<tr>
			<td> Alex </td>
			<td> Chill/indie folk </td>
			<td> Lavender </td>
			<td> 8 </td> 
			<td> <img src="https://i.pinimg.com/originals/6b/bc/ae/6bbcaedf7119d5ab653385feae56d322.png"
					  alt="stuck out tongue with winking eye emoji" 
					  width="50" height="50"/>
			</td>
		</tr>
		
		<tr>
			<td> Zoe </td>
			<td> Jazz </td>
			<td> Burgundy </td>
			<td> 1 </td> 
			<td> <img src="https://clipart.info/images/ccovers/1496184257Hugging-Emoji-png-transparent-Icon.png"
					  alt="hugging emoji" width="50" height="50"/>
			</td>
		</tr>
		
		<tr>
			<td> Noel </td>
			<td> Indie pop rock </td>
			<td> Blue </td>
			<td> 2 </td> 
			<td> <img src="https://clipart.info/images/ccovers/1496184257Hugging-Emoji-png-transparent-Icon.png"
					  alt="hugging emoji" width="50" height="50"/>
			</td>
		</tr>
		
		<tr>
			<td> Rosie </td>
			<td> Electronica </td>
			<td> Deep indigo </td>
			<td> 10 </td> 
			<td> All emojis </td>
		</tr>
		
	</table>
<?php
}
?>