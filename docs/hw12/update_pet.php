<?php
/* 	Alex Childers
	Last modified: 2019/05/10
*/

/* 	Function: update_pet 

	Purpose: Expects a valid username and password to exist in the $_SESSION
		array. Creates a form showing inputs for pet information.
*/

function update_pet()
{
	// try connecting to Oracle 
	$conn = hsu_conn_sess($_SESSION["username"], $_SESSION["password"]);
	
	?>
	<noscript> 
		<p> Please enable JavaScript to use this page. </p> 
	</noscript>
	
	<form method="post"
		  action=
		"<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
		  id="choice-form" >
		<fieldset id="choice-dropdown">
			<legend> Select a pet to update: </legend>   
			<label for="pets"> Pet </label>
			<select id="pets" name="pets">
			<?php
			// query pet ids
			$pet_query_str = "select 	pet_id
							  from		pet
							  order by 	pet_id";
			$pet_query = oci_parse($conn, $pet_query_str); 
			oci_execute($pet_query); 

			while(oci_fetch($pet_query))
			{
				$curr_id = oci_result($pet_query, "PET_ID");
				
				?>
				<option value="<?= $curr_id ?>">
					#<?= $curr_id ?>
				</option>
				<?php
			}
			oci_free_statement($pet_query);
			oci_close($conn); 
			?>
			</select>
		</fieldset>

		<fieldset id="dynamic-form">
			<legend> Update name </legend>
			<label for="name" id="name_label" class="option_label"> Name: </label>
			<input type="text" id="name" name="name" placeholder="" />
			<br /> 
		</fieldset> 

		<div class="sub_button">
			<input type="submit" name="see_menu" value="Back to menu" /> 
			<input type="submit" name="update" value="Update pet" />
		</div>
	</form>
    <?php
}

?>