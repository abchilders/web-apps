<?php
/*	Alex Childers
	Last modified: 2019/05/01
*/

/* 	Function: confirm_sale()
	
	Purpose: Expects the $_POST array to contain a valid ISBN and quantity,
		and $_SESSION to contain a username and password.
		Returns nothing. Displays the chosen ISBN's publisher name, 
		title, author, price, entered quantity, subtotal for this 
		quantity, computed tax for this quantity, and computed total 
		for this quantity including tax. Allows the user to proceed 
		with or cancel the sale. 
		
	TO DO: allow the user to proceed with or cancel the sale at this point
	(if they cancel, should they be logged out or only allowed to input 
	another ISBN? maybe provide a "log out" button on stage 2? 
	
	-ALSO STORE ANY INFO WE NEED FOR SELL_BOOK IN $_SESSION 
	-DISPLAY PRICES WITH TWO DECIMAL PLACES, *ALWAYS ROUNDED UP* 
*/

// constant: in this scenario, sales tax is 8.5%
define("TAX_RATE", 0.085); 

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
	// store isbn and quantity in local variables and in $_SESSION
	$isbn = strip_tags($_POST["isbn"]); 
	$quant = strip_tags($_POST["quantity"]); 
	
	$_SESSION["isbn"] = $isbn; 
	$_SESSION["quantity"] = $quant; 
	
	// we need to select publisher name, title, author, and price for this 
	// title
	$title_str = "select pub_name, title_name, author, title_price
		      from   title t join publisher p 
		      	     on t.pub_id = p.pub_id 
		      where  isbn = :user_isbn"; 
	$title_query = oci_parse($conn, $title_str); 

	// set bind variable for isbn and execute title query 
	oci_bind_by_name($title_query, ":user_isbn", $isbn); 
	
	// execute and store return values in variables-- this query should
	// only return one row  
	oci_execute($title_query, OCI_DEFAULT); 
	oci_fetch($title_query); 
	$pub_name = oci_result($title_query, "PUB_NAME"); 
	$title_name = oci_result($title_query, "TITLE_NAME"); 
	$author = oci_result($title_query, "AUTHOR"); 
	$title_price = oci_result($title_query, "TITLE_PRICE");
	
	// remember title name for sale confirmation in next stage
	$_SESSION["title_name"] = $title_name; 

	// calculate prices
	$subtotal = $quant * $title_price; 
	$tax = $subtotal * TAX_RATE; 
	$total = $subtotal + $tax; 
	
	// convert prices to formatted currency strings 
	$title_price = "$" . number_format($title_price, 2);
	$subtotal = "$" . number_format($subtotal, 2); 
	$tax = "$" . number_format($tax, 2);
	$total = "$" . number_format($total, 2);

	// put all this information into a table 
	?>
	<table>
		<caption> Sale confirmation for ISBN <?= $isbn ?> </caption>
		<tr> 
			<th scope="row"> Publisher name </th>
			<td> <?= $pub_name ?> </td>
		</tr>
		<tr> 
			<th scope="row"> Title </th>
			<td> <?= $title_name ?> </td>
		</tr>
		<tr> 
			<th scope="row"> Author </th>
			<td> <?= $author ?> </td>
		</tr>
		<tr> 
			<th scope="row"> Price per book </th>
			<td> <?= $title_price ?> </td>
		</tr>
		<tr> 
			<th scope="row"> Quantity </th>
			<td> <?= $quant ?> </td>
		</tr>
		<tr> 
			<th scope="row"> Subtotal </th>
			<td> <?= $subtotal ?> </td>
		</tr>
		<tr> 
			<th scope="row"> Tax </th>
			<td> <?= $tax ?> </td>
		</tr>
		<tr> 
			<th scope="row"> <em>Total</em> </th>
			<td> <?= $total ?> </td>
		</tr>
	</table>
	
	<!-- submit buttons to proceed with or cancel the sale --> 
	<form method="post"
		  action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		<div class="sub_button">				
			<input type="submit" name="cancel" 
				value="Cancel" />
			<input type="submit" name="confirm" value="Confirm" />
		</div>
	</form>
	<?php
	oci_free_statement($title_query); 
	oci_close($conn); 
}
?>