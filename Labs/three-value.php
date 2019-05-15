<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    demo of form validation using JavaScript

    by: Sharon Tuttle
    last modified: 2019-04-18

    can run using the URL:
    https://nrs-projects.humboldt.edu/~st10/s19cs328/328lab12/three-value.php
-->

<head>  
    <title> JavaScript form validation </title>
    <meta charset="utf-8" />

    <?php
        require_once("make_three_value_form.php");
        require_once("make_three_value_response.php");
    ?>

    <link href="https://users.humboldt.edu/smtuttle/styles/normalize.css" 
          type="text/css" rel="stylesheet" />
    <link href="three-value-form.css"
          type="text/css" rel="stylesheet" />

    <script src="three-value.js" type="text/javascript" async="async">
            </script>
</head> 

<body> 
    <?php
    // assuming that, if the first textfield's name is not
    //     in the $_GET array, should display that form

    if (! array_key_exists("first", $_GET))    
    {
        make_three_value_form();
    }

    // ...but if it IS, should display form-response instead

    else
    {
        make_three_value_response();
    }

    require_once("328footer.html");
?>
