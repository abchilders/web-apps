<?php
/*	Alex Childers
	Last modified: 2019/04/29
*/

/* 	Function: confirm_sale()
	
	Purpose: Expects the $_POST array to contain a valid ISBN and quantity, 
		 returns nothing. Displays the chosen ISBN's publisher name, 
		 title, author, price, entered quantity, subtotal for this 
		 quantity, computed tax for this quantity, and computed total 
		 for this quantity including tax. Allows the user to proceed 
		 with or cancel the sale. 
		
	TO DO: allow the user to proceed with or cancel the sale at this point
	(if they cancel, should they be logged out or only allowed to input 
	another ISBN? maybe provide a "log out" button on stage 2? 
*/

function confirm_sale()
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
	// we need to select publisher name, title, author, and price for this 
	// title
	$title_str = "select pub_name, title_name, author, title_price
		      from   title t join publisher p 
		      	     on t.pub_id = p.pub_id 
		      where  isbn = :user_isbn"; 
	$title_query = oci_parse($conn, $title_str); 

	// set bind variable for isbn and execute title query 
	$isbn = strip_tags($_POST["isbn"]); 
	$quant = strip_tags($_POST["quantity"]); 

	oci_bind_by_name($title_query, ":user_isbn", $isbn); 
	
	// execute and store return values in variables-- this query should
	// only return one row  
	oci_execute($title_query, OCI_DEFAULT); 
	oci_fetch($title_query); 
	$pub_name = oci_result($title_query, "PUB_NAME"); 
	$title_name = oci_result($title_query, "TITLE_NAME"); 
	$author = oci_result($title_query, "AUTHOR"); 
	$title_price = oci_result($title_query, "TITLE_PRICE"); 

	// calculate prices 
	$subtotal = $quant * $title_price; 
	// TO DO: CALCULATE TAX
	$tax = 0; 
	$total = $subtotal + $tax; 

	// LEFT OFF HERE
	// put all this information into a table 
	?>
	<table>
		<caption> 
	</table>
	<?php
}
?>