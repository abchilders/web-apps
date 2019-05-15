<?php
/* 	Alex Childers
	Last modified: 2019/04/24
*/
	
/* 
	Function: add_owner_info
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain a valid owner ID and possibly an email and phone number. 
		The $_SESSION array should contain a valid Oracle username and 
		password. Adds the new contact information to all applicable tables.
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function add_owner_info()
{
	// does an owner ID exist in $_POST? 
	if( (! array_key_exists("own_id", $_POST)) or
		($_POST["own_id"] == "") or 
		(! isset($_POST["own_id"])) )
	{
		destroy_and_exit("Must select an owner."); 
	}
	
	// log in to Oracle
	$username = $_SESSION["username"]; 
	$password = $_SESSION["password"];  
	$conn = hsu_conn_sess($username, $password); 
	
	// if we've reached here, we have successfully connected.
	
	// select the owner's name before deleting; will use for feedback
	$owner_query_str = "select	first_name, last_name
						from	owner
						where 	owner_id = :own_id";
	$owner_stmt = oci_parse($conn, $owner_query_str); 
	
	// create bind variable
	$own_id = strip_tags($_POST["own_id"]);
	oci_bind_by_name($owner_stmt, ":own_id", $own_id);
	oci_execute($owner_stmt, OCI_DEFAULT); 
	
	// store the results of that query - should only return one row, 
	// since owner IDs are unique
	oci_fetch($owner_stmt);
	$owner_name = oci_result($owner_stmt, "FIRST_NAME") . " " 
					. oci_result($owner_stmt, "LAST_NAME"); 
	oci_free_statement($owner_stmt); 
	
	// does any new contact information exist in $_POST?
	if( ((! array_key_exists("owner_phone", $_POST)) or
		 ($_POST["owner_phone"] == "") or 
		 (! isset($_POST["owner_phone"])) )
		 and 
		((! array_key_exists("owner_email", $_POST)) or
		($_POST["owner_email"] == "") or 
		(! isset($_POST["owner_email"])))
	  )
	{
		?>
		<p> No new contact information was added. </p> 
		<?php
	}
	else
	{
		// does a new phone number exist in $_POST?
		if(array_key_exists("owner_phone", $_POST))
		{
			$new_phone = strip_tags($_POST["owner_phone"]); 
			
			// insert this new phone number into the database 
			$phone_insert_str = "insert into owner_phone_num
								 values
								 (:own_id, :new_phone)"; 
			$phone_stmt = oci_parse($conn, $phone_insert_str); 
			
			// set bind variables
			oci_bind_by_name($phone_stmt, ":own_id", $own_id); 
			oci_bind_by_name($phone_stmt, ":new_phone", $new_phone); 
			
			// execute insertion 
			oci_execute($phone_stmt, OCI_DEFAULT); 
			oci_commit($conn); 
			oci_free_statement($phone_stmt); 
		}
		
		// does a new email exist in $_POST?
		if(array_key_exists("owner_email", $_POST))
		{
			$new_email = strip_tags($_POST["owner_email"]);
			
			// insert this new phone number into the database 
			$email_insert_str = "insert into owner_email_addr
								 values
								 (:own_id, :new_email)"; 
			$email_stmt = oci_parse($conn, $email_insert_str); 
			
			// set bind variables
			oci_bind_by_name($email_stmt, ":own_id", $own_id); 
			oci_bind_by_name($email_stmt, ":new_email", $new_email); 
			
			// execute insertion 
			oci_execute($email_stmt, OCI_DEFAULT); 
			oci_commit($conn); 
			oci_free_statement($email_stmt);
		}
	}
	
	// display new owner contact information 
	?>
	
	<table>
		<caption> All contact information for owner #<?= $own_id ?> </caption>
		<tr>
			<th scope="row"> Name </th> 
			<td> <?= $owner_name ?> </td> 
		</tr>
		<tr>
			<th scope="row"> Phone numbers </th>
			<td>
				<ul>
				<?php
				// select all phone numbers for this owner 
				$phone_query_str = "select 	phone_number
									from 	owner_phone_num
									where	owner_id = :own_id"; 
				$phone_query = oci_parse($conn, $phone_query_str); 
				oci_bind_by_name($phone_query, ":own_id", $own_id); 
				oci_execute($phone_query, OCI_DEFAULT);
				
				// enumerate phone numbers
				while(oci_fetch($phone_query))
				{
					$next_phone_num = oci_result($phone_query, "PHONE_NUMBER"); 
					?>
					<li> <?= $next_phone_num ?> </li> 
					<?php
				}
				oci_free_statement($phone_query); 
				?>
				</ul>
			</td>
		</tr>
		<tr>
			<th scope="row"> Email addresses </th>
			<td>
				<ul>
				<?php
				// select all email addresses for this owner 
				$email_query_str = "select 	email
									from 	owner_email_addr
									where	owner_id = :own_id"; 
				$email_query = oci_parse($conn, $email_query_str); 
				oci_bind_by_name($email_query, ":own_id", $own_id); 
				oci_execute($email_query, OCI_DEFAULT);
				
				// enumerate phone numbers
				while(oci_fetch($email_query))
				{
					$next_email = oci_result($email_query, "EMAIL"); 
					?>
					<li> <?= $next_email ?> </li> 
					<?php
				}
				oci_free_statement($email_query); 
				oci_close($conn); 
				?>
				</ul>
			</td>
		</tr>
	</table>
	
	<form method="post"
		  action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
		<div class="sub_button">				
			<input type="submit" name="add_more" 
				value="Add more contact information" />
			<input type="submit" name="logout" value="Log out" />
		</div>
	</form>
	<?php
}
?>