<?php
/* 	Alex Childers
	Last modified: 2019/05/01
*/

/*	Function: sell_book
	Purpose: Expects a book's ISBN, its title, a quantity to sell, 
		a valid username, and a valid password to exist in the 
		$_SESSION array. Returns nothing. Calls the PL/SQL procedure 
		sell_book and displays a confirmation of the sale. 
*/

function sell_book()
{
	// does an isbn exist in $_SESSION? 
	if( (! array_key_exists("isbn", $_SESSION)) or
		($_SESSION["isbn"] == "") or 
		(! isset($_SESSION["isbn"])) )
	{
		destroy_and_exit("Must select an ISBN."); 
	}
	
	// does a quantity exist in $_SESSION? 
	if( (! array_key_exists("quantity", $_SESSION)) or
		($_SESSION["quantity"] == "") or 
		(! isset($_SESSION["quantity"])) )
	{
		destroy_and_exit("Must enter a quantity to sell."); 
	}
	
	// log in to Oracle
	$username = $_SESSION["username"]; 
	$password = $_SESSION["password"];  
	$conn = hsu_conn_sess($username, $password); 
	
	// if we've reached here, we have successfully connected.
	
	// call sell_book to update the database
	$isbn = $_SESSION["isbn"]; 
	$quantity = $_SESSION["quantity"]; 
	$title_name = $_SESSION["title_name"]; 
	
	$sell_book_str = "begin :exit_code := sell_book(:isbn, :quantity); end;"; 
	$sell_book_op = oci_parse($conn, $sell_book_str); 
	
	// set bind variables 
	oci_bind_by_name($sell_book_op, ":isbn", $isbn); 
	oci_bind_by_name($sell_book_op, ":quantity", $quantity); 
	oci_bind_by_name($sell_book_op, ":exit_code", $exit_code, 2); 
	
	// execute sell_book
	oci_execute($sell_book_op, OCI_DEFAULT); 
	oci_free_statement($sell_book_op); 
	
	// query the new quantity on hand for feedback 
	$qty_on_hand_str = "select qty_on_hand
							 from	title 
							 where 	isbn = :user_isbn"; 
	$qty_on_hand_stmt = oci_parse($conn, $qty_on_hand_str); 
	oci_bind_by_name($qty_on_hand_stmt, ":user_isbn", $isbn); 
	oci_execute($qty_on_hand_stmt); 
	oci_fetch($qty_on_hand_stmt); 
	$qty_on_hand = oci_result($qty_on_hand_stmt, "QTY_ON_HAND"); 
	oci_free_statement($qty_on_hand_stmt);
	
	// give feedback based on return code 
	if($exit_code === "0")
	{
		// sale was successful; display confirmation and allow user to 
		// sell another book 
		?>
		<p> <?= $quantity ?> copies of <?= $title_name ?> were
			successfully sold. </p> 
		<p> There are now <?= $qty_on_hand ?> copies of <?= $title_name ?> on
			hand. </p> 
		<?php
	}
	else
	{
		// sale was unsuccessful. give feedback based on exit code
		if($exit_code === "-1")
		{
			?>
			<p> Error: ISBN <?= $isbn ?>, <?= $title_name ?>, does not exist
				in this store. </p> 
			<?php
		}
		elseif($exit_code === "-2")
		{
			?>
			<p> Error: Can't sell a negative quantity of <?= $quantity ?> 
				books. </p> 
			<?php
		}
		elseif($exit_code === "-3")
		{
			// there's not enough books on hand to sell the desired quantity. 
			
			?>
			<p> Error: Sale quantity <?= $quantity ?> exceeds stock of 
				<?= $qty_on_hand ?> books on hand. 
			</p>
			<?php
		}
		// if exit_code === -4 or any other weird return value 
		else
		{
			// other, unknown error 
			?>
			<p> Unknown error occurred. Please try again. </p>
			<?php
		}
	}
	?> 
		
	<form method="post"
		  action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		<div class="sub_button">				
			<input type="submit" name="sell_more" 
				value="Sell another book" />
			<input type="submit" name="logout" value="Log out" />
		</div>
	</form>
	
	<?php
	oci_close($conn); 
}
?>