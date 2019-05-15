<?php
/* 	Alex Childers
	Last modified: 2019/04/21
*/
	
/* 
	Function: need_order_form - void -> void
	
	Purpose: Expects nothing, returns nothing. Has the side effect of 
		creating the form needed for entering one's Oracle username, 
		password, the desired ISBN, and the desired order quantity for
		the suggested order needed. 
		
	Uses: oracle-login-fieldset.html
*/

function login_form()
{
	?>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'],
								ENT_QUOTES) ?>" 
		  method="post">
	<?php
		require_once("oracle-login-fieldset.html"); 
	?>
	<div class="sub_button">
		<input type="submit" value="Log in" />
	</div>
</form>
<?php
}
?>