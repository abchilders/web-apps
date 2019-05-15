<?php
/* 	Alex Childers
	Last modified: 2019/04/21
*/
	
/* 
	Function: insert_order
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain a valid ISBN and order quantity, and the $_SESSION array should
		contain a valid Oracle username and password. Inserts the ISBN and the 
		order quantity from the $_POST array into the order_needed table. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function insert_order()
{
	// does an ISBN exist in $_POST? 
	if( (! array_key_exists("isbn", $_POST)) or
		($_POST["isbn"] == "") or 
		(! isset($_POST["isbn"])) )
	{
		destroy_and_exit("Must select a title."); 
	}
	
	// does a valid order quantity exist in $_POST?
	if( (! array_key_exists("quantity", $_POST)) or
		($_POST["quantity"] == "") or 
		(! isset($_POST["quantity"])) or
		($_POST["quantity"] < 0) )
	{
		destroy_and_exit("Must enter a valid order quantity."); 
	}
	
	// log in to Oracle
	$username = $_SESSION["username"]; 
	$password = $_SESSION["password"];  
	$conn = hsu_conn_sess($username, $password); 
	
	// if we've reached here, we have successfully connected.
	
	// create call to insert_order_needed 
	$insert_order_needed_call = "begin insert_order_needed(:new_isbn,
														   :new_quantity);
								 end;"; 
								 
	$insert_order_needed_stmt = oci_parse($conn, $insert_order_needed_call); 
	
	// set bind variables representing arguments for insertion
	$new_isbn = strip_tags($_POST["isbn"]); 
	$new_quantity = strip_tags($_POST["quantity"]); 
	
	oci_bind_by_name($insert_order_needed_stmt, ":new_isbn", $new_isbn);
	oci_bind_by_name($insert_order_needed_stmt, ":new_quantity", 
		$new_quantity); 
	
	// run insert_order_needed()
	oci_execute($insert_order_needed_stmt, OCI_DEFAULT); 
	
	// commit changes
	oci_commit($conn); 
	
	// free statement
	oci_free_statement($insert_order_needed_stmt); 
	
	// give feedback
	// how many rows does the order_needed table now have?
	$quant_query = "select count(*)
					from order_needed"; 
	$quant_stmt = oci_parse($conn, $quant_query); 
	oci_execute($quant_stmt, OCI_DEFAULT); 
	oci_fetch($quant_stmt); 
	$num_order_needed_rows = oci_result($quant_stmt, "COUNT(*)"); 
	?>
	<p> Inserted order needed for <?= $new_quantity ?> copies of title with
		ISBN <?= $new_isbn ?>. 
	</p>
	<p>
		There are now <?= $num_order_needed_rows ?> orders needed in the
		<code> order_needed </code> table. 
	</p>
	<?php
		// free statement and close connection
		oci_free_statement($quant_stmt); 
		oci_close($conn); 
	?>
	
	<p>
		<a href="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>">
			Insert another order. 
		</a>
	</p>
	<?php
}
?>