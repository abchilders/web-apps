<?php
	/* 
		Function: need_order_form - void -> void
		
		Purpose: Expects nothing, returns nothing. Has the side effect of 
			creating the form needed for entering one's Oracle username, 
			password, the desired ISBN, and the desired order quantity for
			the suggested order needed. 
	*/
	
	function need_order_form()
	{
		?>
		<form action="<?= htmlentities($_SERVER['PHP_SELF'],
									ENT_QUOTES) ?>" 
			  method="post">
		<fieldset>
			<legend> Request an order </legend>
			<fieldset>
				<legend> Order information </legend>
				
				<label for="isbn"> ISBN: </label>
				<select id="isbn" name="isbn" >
					<option value="0201106868"> 0201106868 </option>
					<option value="0201111160"> 0201111160 </option>
					<option value="0805367802"> 0805367802 </option>
					<option value="0805367829"> 0805367829 </option>
					<option value="0871507870"> 0871507870 </option>
				</select>
				<br />
				
				<label for="quantity"> Order quantity: </label>
				<input type="number" id="quantity" name="quantity" 
					required="required" />
			</fieldset>
			
			<?php
				require_once("oracle-login-fieldset.html"); 
			?>
		</fieldset>
	</form>


	<?php
	}
?>