<?php
/* 	Alex Childers
	Last modified: 2019/04/22
*/
	
/* 
	Function: check_order_status
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain a valid ISBN, and the $_SESSION array should contain a 
		valid Oracle username and password. Inserts the ISBN and the 
		order quantity from the $_POST array into the order_needed table. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function check_order_status()
{
	// does an ISBN exist in $_POST? 
	if( (! array_key_exists("isbn", $_POST)) or
		($_POST["isbn"] == "") or 
		(! isset($_POST["isbn"])) )
	{
		destroy_and_exit("Must select a title."); 
	}
	
	// if so, log in to Oracle
	$username = $_SESSION["username"]; 
	$password = $_SESSION["password"];  
	$conn = hsu_conn_sess($username, $password); 
	
	// if we've reached here, we have successfully connected.
		
	// call is_on_order()
	$is_on_order_call = 
		"begin :on_order := bool_to_string(is_on_order(:isbn)); end;"; 
	$is_on_order_stmt = oci_parse($conn, $is_on_order_call);  
	
	// set input bind variable isbn
	$isbn = strip_tags($_POST["isbn"]); 
	oci_bind_by_name($is_on_order_stmt, ":isbn", $isbn);
	
	// set output bind variable on_order. fourth parameter is size
	oci_bind_by_name($is_on_order_stmt, ":on_order", $on_order, 5); 
	
	// execute function call
	oci_execute($is_on_order_stmt, OCI_DEFAULT); 
	
	// free statement
	oci_free_statement($is_on_order_stmt);
	
	// now call pending_order_needed in a similar manner
	$pending_order_call = "begin :has_pending_need := 
						bool_to_string(pending_order_needed(:isbn)); end;"; 
	$pending_order_stmt = oci_parse($conn, $pending_order_call); 
	
	oci_bind_by_name($pending_order_stmt, ":isbn", $isbn);
	
	// output bind variable has_pending_need. fourth parameter is size
	oci_bind_by_name($pending_order_stmt, ":has_pending_need", 
					 $has_pending_need, 5); 
	
	oci_execute($pending_order_stmt, OCI_DEFAULT); 
	oci_free_statement($pending_order_stmt);
	
	// get the isbn's title name 
	$title_query_str = "select 	title_name
						from	title
						where	isbn = :isbn"; 
	$title_query = oci_parse($conn, $title_query_str); 
	oci_bind_by_name($title_query, ":isbn", $isbn); 
	oci_execute($title_query); 
	
	// the above statement should only have returned one title name, since 
	// ISBNs are unique 
	oci_fetch($title_query); 
	$title_name = oci_result($title_query, "TITLE_NAME"); 
	oci_free_statement($title_query); 
	
	oci_close($conn);
	
	//now output results to web page
	?>
	<p> Status of ISBN <?= $isbn ?>, <?= $title_name ?>: <br />
		<?= $isbn ?> is 
		<?php
		if($on_order === "FALSE")
		{
			?>
			not
			<?php
		}
		?>
		on order. <br />
		
		<?= $isbn ?>  
		<?php
		if($has_pending_need === "FALSE")
		{
			?>
			does not have
			<?php
		}
		else
		{
			?>
			has
			<?php
		}
		?>
		a pending order needed.
	</p>
	
	<p>
		<a href="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>">
			Request status of another ISBN.
		</a>
	</p>
	<?php
}
?>