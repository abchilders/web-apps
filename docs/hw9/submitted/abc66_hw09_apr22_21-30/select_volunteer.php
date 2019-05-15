<?php
/* 	Alex Childers
	Last modified: 2019/04/22
*/
	
/* 
	Function: select_volunteer
	
	Purpose: Expects nothing, returns nothing. Expects the $_POST array to 
		contain a valid Oracle username and password; it destroys the 
		session and exits if not. Shows a dropdown menu of volunteer IDs and
		their names. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function select_volunteer()
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
			
	// build a form with a dropdown of volunteers  
	?>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>" 
		  method="post">
		<fieldset>
			<legend> Delete a volunteer </legend>
			<p> *Be certain to double-check which volunteer you want to delete
				before submitting! </p> 
			<label for="vol_id"> Volunteer </label> 
			<select id="vol_id" name="vol_id">
			<?php
			// query volunteer info
			$vol_query_str = "select 	v.worker_id, first_name, last_name
							  from		worker w join volunteer v 
										on w.worker_id = v.worker_id
							  order by	v.worker_id";
			$vol_query = oci_parse($conn, $vol_query_str); 
			oci_execute($vol_query); 

			while(oci_fetch($vol_query))
			{
				?>
				<p> entered while loop </p> 
				<?php
				$curr_vol_id = oci_result($vol_query, "WORKER_ID"); 
				
				// turns out you can concatenate oci_result()'s return values 
				$curr_vol_name = oci_result($vol_query, "FIRST_NAME") 
								 . " " . oci_result($vol_query, "LAST_NAME"); 
				?>
				<p> <?= $curr_vol_id ?> </p>
				<p> <?= $curr_vol_name ?> </p>
				<option value="<?= $curr_vol_id ?>">
					<?= $curr_vol_id . " - " . $curr_vol_name ?> 
				</option>
				<?php
			}
			?>
			</select>
		</fieldset>
		<div class="sub_button">
			<input type="submit" value="Delete" />
		</div>
	</form>
	<?php
}
?>