<?php
/* 	Alex Childers
	Last modified: 2019/04/21
*/
	
/* 
	Function: create_dropdown
	
	Purpose: Expects a connection object, returns nothing. Dynamically creates a 
		dropdown menu of ISBNS and their titles. 
		
	Uses: destroy_and_exit.php, hsu_conn_sess.php
*/

function create_dropdown($conn)
{
	// query title isbns and names 
	$title_query_str = "select 		isbn, title_name
						from 		title
						order by	title_name"; 
	$title_query = oci_parse($conn, $title_query_str); 
	oci_execute($title_query); 
	?>

	<label for="isbn"> ISBN: </label>
	<select id="isbn" name="isbn">
	<?php
	while (oci_fetch($title_query))
	{
		$curr_isbn = oci_result($title_query, "ISBN"); 
		$curr_title_name = oci_result($title_query, "TITLE_NAME"); 
		?>
		<option value="<?= $curr_isbn ?>">
			<?= $curr_isbn . " - " . $curr_title_name ?>
		</option>
		<?php
	}
	?>
	</select>
	<?php
	oci_free_statement($title_query); 
	oci_close($conn); 
}
?>