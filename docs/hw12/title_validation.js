"use strict";

// Alex Childers
// Last modified: 2019/05/10

// add event handler function to a form that validates the 
// book order quantity 

window.onload = function()
	{
		// add form validation function to a form if it exists 
		var titleForm = document.getElementById("title_sale"); 
		
		// only add handler if this form exists at this state 
		if (titleForm != null)
		{
			// use validQuant to validate titleForm before submission 
			titleForm.onsubmit = validQuant; 
		}
	}
	
/* 	function: maxQuant
	
	expects nothing. returns the qty_on_hand of the isbn selected in the 
		document 
*/

function maxQuant()
{
	var isbnDropdown = document.getElementById("isbn"); 
	var userChoice = isbnDropdown.value; 
	var qtyOnHand = -1; 
	
	// request quantity via Ajax 
	var ajax = new XMLHttpRequest();
	ajax.responseType = "document";
    ajax.overrideMimeType("text/xml");

    ajax.onreadystatechange =
        function()
        {
            if (ajax.readyState == 4)
            {
                if (ajax.status == 200)
                {
                    // this request sends back the query result- grab contents
					// and return max quantity 
 
                    var quantities =
                        ajax.responseXML.getElementsByTagName("quantity");

                    var nextOptionText;
					
					// we know there's only one quantity in the XML
					qtyOnHand = parseInt(quantities[0].firstChild.nodeValue); 
                }
                else
                {
                    alert("ERROR fetching query results: "
                        + ajax.status + " - " + ajax.statusText);
                }
            }
        };    

    ajax.open("GET", 
        "book_quant_query.php?choice=" + userChoice, 
        true);
    ajax.send(null);
	return qtyOnHand; 
}
	
/* 	function: validQuant 

	expects nothing. returns true if the quantity in the form is between 
		1 and the qty_on_hand (inclusive) of the chosen isbn; false otherwise 
*/
function validQuant()
{
	// grab the document's body element
    var bodyObjectArray = document.getElementsByTagName("body");

    // I know there's just one body element, I am grabbing it
    var bodyObject = bodyObjectArray[0];
	
	// get input fields' objects 
	var isbnField = document.getElementById("isbn"); 
	var quantField = document.getElementById("quantity"); 
	
	// get fields' current values 
	var isbnVal = isbnField.value; 
	var quantVal = quantField.value; 
	
	// assume form is fine unless proven otherwise 
	var result = true; 
	
	// create an errors paragraph unless one already exists
    var errorsPara = document.getElementById("errors");

    if (errorsPara)
    {
        // clear out its current contents
        errorsPara.innerHTML = "";

        // remove from document
        bodyObject.removeChild(errorsPara);
    }

    else
    {
        errorsPara = document.createElement("p");
        errorsPara.id = "errors";
    }
	
	// complain and returns if any fields are empty OR just
    //   white space
    if ( (! isbnVal.trim() ) || (! quantVal.trim()) )
    {
        errorsPara.innerHTML = "MUST fill in ALL fields "
            + "before submit! (white space won't do!)";
        result = false;
    }
	
	// determine if quantity is valid- between 1 and qty_on_hand 
	var qtyOnHand = maxQuant(); 
	if((parseInt(quantField) < 1) || (parseInt(quantField) > qtyOnHand))
	{
		errorsPara.innerHTML += "Sale quantity must be at least 1 and " 
			+ "at most " + qtyOnHand + " (the quantity on hand)."; 
		result = false; 
	}
	
	// ONLY add error paragraph if the result flag is false

    if (result === false)
    {
        // get form's DOM object
		var titleForm = document.getElementById("title_sale"); 

        // insert error paragraph BEFORE form in the body
        bodyObject.insertBefore(errorsPara, titleForm);
    }
    return result;
}