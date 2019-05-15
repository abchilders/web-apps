<?php
/* 	Alex Childers
	Last modified: 2019/04/28
*/

/*	Function: sell_book
	Purpose: Expects a book title and the number of copies sold in the 
		$_SESSION array (?). Returns nothing. Calls the PL/SQL procedure 
		sell_book and displays a confirmation of the sale. 
		
	CURRENTLY STILL A STUB OF SORTS. 
*/

function sell_book()
{
	?>
	<p> Stage 4: sell_book. Display sale confirmation and either sell another
		book or log out. </p> 
		
	<form method="post"
		  action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		<div class="sub_button">				
			<input type="submit" name="sell_more" 
				value="Sell another book" />
			<input type="submit" name="logout" value="Log out" />
		</div>
	</form>
	
	<?php
}

?>