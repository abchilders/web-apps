<?php
/* 	Alex Childers
	Last modified: 2019/04/21
*/
	
/* 
	Function: get_order_info
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain a valid Oracle username and password; it destroys the 
		session and exits if not. Shows a dropdown menu of ISBNS and their 
		titles, as well as a quantity to order. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php, create_dropdown.php
*/

function get_order_info()
{
	// determine if username/password exists
	if( (! array_key_exists("username", $_POST)) or 
		(! array_key_exists("password", $_POST)) or 
		($_POST["username"] == "") or 
		($_POST["password"] == "") or
		(! isset($_POST["username"])) or 
		(! isset($_POST["password"])) )
	{
		destroy_and_exit("Must enter a username and password."); 
	}
	
	// if so, save them and connect to Oracle 
	$username = strip_tags($_POST["username"]); 
	$password = $_POST["password"]; 
	$_SESSION["username"] = $username; 
	$_SESSION["password"] = $password; 
	$conn = hsu_conn_sess($username, $password); 
	
	// build a form with a dropdown 
	?>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>" 
		  method="post">
		<fieldset>
			<legend> Request an order </legend>
			<?php
			create_dropdown($conn); 
			?>
			<br />
			
			<label for="quantity"> Order quantity: </label>
			<input type="number" id="quantity" name="quantity" min="1"
				required="required" />
		</fieldset>
		<div class="sub_button">
			<input type="submit" value="Submit order request" />
		</div>
	</form>
	<?php
}
?>