<?php
/*	by: Rawan Almakhloog, Alex Childers, Sthephany Ponce
    last modified: 2019/04/12
*/

/*=====
    function: create_login: void -> void
    purpose: expects nothing, returns nothing, and has the side-effect
        of outputting to the resulting document an Oracle log-on form
        with method="post" and action equal to the calling PHP document

    requires: name-pwd-fieldset.html, 328footer.html
	by: Sharon Tuttle
=====*/

function create_login()
{
    // create the desired Oracle log-in form
    ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                       ENT_QUOTES) ?>">      
        <?php
        require_once("name-pwd-fieldset.html");
        ?>
            <input type="submit" value="login" />
        </form>
        <?php
}

/*=====
    function: create_pub_dropdown: void -> void
    purpose: expects nothing, and returns nothing, BUT does
        expect the $_POST array to contain a key "username"
        with a valid Oracle username, and a key "password"
        with a valid Oracle password;
      
        ...if it cannot find these, or if it cannot make a
        valid connection to Oracle using these, it 
        destroys the session and exits;

        ...otherwise, it tries to output to the resulting
        document a dynamically-created dropdown with the current
        publishers' names 

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function create_pub_dropdown()
{
	// first: IS there at least an attempt at a username/password?

    if ( (! array_key_exists("username", $_POST)) or
         (! array_key_exists("password", $_POST)) or
         ($_POST["username"] == "") or
         ($_POST["password"] == "") or
         (! isset($_POST["username"])) or
         (! isset($_POST["password"])) )
    {
        destroy_and_exit("must enter a username and password!");
    }

    // if reach here, DO have a username and password; 

    $username = strip_tags($_POST["username"]);

    // ONLY using password to log in, so NOT sanitizing it (gulp?)
    
    $password = $_POST["password"];

    // save these for later (should be OK to do now, I THINK, because if
    //     connection fails, WILL be destroying session, and these,
    //     later)
    
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    //   NOW: can you connect to Oracle with them?
    //     (NOTE that hsu_conn_sess destroys session and
    //     exits the PHP document if it fails...!)

    $conn = hsu_conn_sess($username, $password);

    // if reach here -- CONNECTED!

    // try to query department names; I am desiring to grab their
    //     numbers, too

    $pub_query_str = "select pub_name, pub_id
                       from publisher";
    $pub_query = oci_parse($conn, $pub_query_str);
    oci_execute($pub_query);

    // build a form with a dropdown

    ?>
    <form method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <fieldset>
            <legend> Select desired publisher </legend>
            <select name="pub_choice">
            <?php
            while (oci_fetch($pub_query))
            {
                $curr_pub_name = oci_result($pub_query, "PUB_NAME");
                $curr_pub_id = oci_result($pub_query, "PUB_ID");
                ?>
                <option value="<?= $curr_pub_id ?>"> 
                    <?= $curr_pub_name ?> </option>
                <?php
            }
            ?>
            </select>
        </fieldset>
        <input type="submit" value="submit choice" />        
    </form>

    <?php
    oci_free_statement($pub_query);
    oci_close($conn);
}

/*=====
    function: get_pub_titles: void -> void
    purpose: expects nothing, and returns nothing,
        BUT expects the current $_POST array to include a key "pub_choice"
        and expects the current $_SESSION array to include 
            keys "username" and "password" whose values are
            a valid Oracle username and password,
        and has the side-effects of trying to log into Oracle,
	 query for the names of titles from this publisher,
        display these in a reasonable manner,
	 and conclude with the option to either finish or select another publisher

    requires: 328footer.html, destroy_and_exit.php,
              hsu_conn_sess.php
=====*/

function get_pub_titles()
{
	// first: IS there a publisher choice?

    if ( (! array_key_exists("pub_choice", $_POST)) or
         ($_POST["pub_choice"] == "") or
         (! isset($_POST["pub_choice"])) )
    {
        destroy_and_exit("must select a publisher!");
    }
    
    // if reach here, DO have a publisher;

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    
    $conn = hsu_conn_sess($username, $password);

    // if reach here, connected!
	
	
    // sanitize user input

    $pub_choice = htmlspecialchars(strip_tags($_POST["pub_choice"]));
	
	// select publisher's name to output to screen 

    $pub_name_str =  "select pub_name
						from publisher
						where pub_id = :chosen_pub_id";

    $pub_name_stmt = oci_parse($conn, $pub_name_str);

    oci_bind_by_name($pub_name_stmt, ":chosen_pub_id", $pub_choice);

    oci_execute($pub_name_stmt);
    oci_fetch($pub_name_stmt);

    $pub_name = oci_result($pub_name_stmt, "PUB_NAME");

    oci_free_statement($pub_name_stmt);
	
	?>
	<h2> <?= $pub_name ?> has titles: </h2>
	<ul>
	<?php

    // try to query publisher's title names 

    $pub_titles_str = "select title_name
                     from title t join publisher p
						on t.pub_id = p.pub_id
                     where p.pub_id = :chosen_pub_id";

    $pub_titles_stmt = oci_parse($conn, $pub_titles_str);

    oci_bind_by_name($pub_titles_stmt, ":chosen_pub_id", $pub_choice);
    oci_execute($pub_titles_stmt);

    // list title names of titles from the selected publisher 

    while (oci_fetch($pub_titles_stmt))
	{
		$title = oci_result($pub_titles_stmt, "TITLE_NAME");
		?>
		<li><?= $title ?></li>
		<?php
	}
	
	oci_free_statement($pub_titles_stmt);
	
	?>
    </ul>
	<form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"
		  method="post">
		  <input type="submit" name="done" value="done" />
		  <input type="submit" name="get_another_publisher" 
			value="get another publisher" />
	</form>
    <?php
}

?>