<?php
/* 	Alex Childers
	Last modified: 2019/04/24
*/
	
/* 
	Function: select_owner
	
	Purpose: Expects a username and password to exist in $_SESSION, returns 
		nothing. Shows a dropdown menu of owners and inputs for owner's email 
		address and phone number. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function select_owner($username, $password)
{
	// try connecting to Oracle
	$conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]); 
			
	// build a form with a dropdown of owners and contact info input fields
	?>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>" 
		  method="post">
		<fieldset>
			<legend> Add owner contact information </legend>
			
			<div id="owner_form">
			
				<!-- owner dropdown --> 
				<label for="own_id"> Owner: </label> 
				<select id="own_id" name="own_id">
				<?php
				// query owner info
				$owner_query_str = "select 	owner_id, first_name, last_name
								  from		owner
								  order by 	last_name";
				$owner_query = oci_parse($conn, $owner_query_str); 
				oci_execute($owner_query); 

				while(oci_fetch($owner_query))
				{
					$curr_owner_id = oci_result($owner_query, "OWNER_ID");
					
					// turns out you can concatenate oci_result()'s return 
					// values 
					$curr_owner_name = oci_result($owner_query, "FIRST_NAME") 
									 . " " . oci_result($owner_query, 
									 "LAST_NAME"); 
					?>
					<option value="<?= $curr_owner_id ?>">
						<?= $curr_owner_name ?> (ID #<?= $curr_owner_id ?>) 
					</option>
					<?php
				}
				oci_free_statement($owner_query);
				oci_close($conn); 
				?>
				</select>
				
				<!-- contact information inputs --> 
				<label for="owner_phone"> Add a phone number: </label>
				
				<input type="tel" id="owner_phone" name="owner_phone"
				   pattern="[0-9]{3}[0-9]{3}[0-9]{4}" 
				   placeholder="7075551234"/>
				
				<label for="owner_email"> Add an email address: </label> 
				<input type="email" id="owner_email" name="owner_email" 
					placeholder="name@email.com" />
			</div>
			
		</fieldset>
		<div class="sub_button">
			<input type="submit" name="see_menu" value="Back to menu" />
			<input type="submit" name="add_info" 
				value="Add new contact info" />
		</div>
	</form>
	<?php
}
?>