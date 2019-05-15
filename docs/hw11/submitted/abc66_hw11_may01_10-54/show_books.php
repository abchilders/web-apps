<?php
/* 	Alex Childers
	Last modified: 2019/05/01
*/
	
/* 
	Function: show_books
	
	Purpose: Expects a username and password, returns nothing. Destroys the 
		session and exits if username or password is invalid. Otherwise, 
		shows a dropdown menu of ISBNS and their titles, as well as a quantity 
		to order. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php, create_dropdown.php
*/

function show_books()
{
	// try connecting to Oracle
	$conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);  
	
	// build a form with a dropdown 
	?>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>" 
		  method="post">
		<fieldset>
			<legend> Sell a book </legend>
			<?php
			create_dropdown($conn); 
			?>
			<br />
			
			<label for="quantity"> Sale quantity: </label>
			<input type="number" id="quantity" name="quantity" min="1"
				required="required" />
		</fieldset>
		<div class="sub_button">
			<input type="submit" value="Confirm sale" />
		</div>
	</form>
	<?php
	oci_close($conn); 
}
?>