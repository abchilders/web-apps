"use strict"; 

// Alex Childers
// Last modified: 2019/05/10
// Creates a form based on the pet selected from a dropdown. 

window.onload = function()
	{
		// get the dropdown of pets 
		var petChoiceMenu = document.getElementById("pets"); 
		
		// attach an onchange attribute with an event handler to this dropdown 
		petChoiceMenu.onchange = fillForm; 
	};
	
// function: fillForm
// expects nothing, returns nothing. requests info to fill a form based 
// 	on the user's pet choice

function fillForm()
{
	// which pet has been chosen? 
	var petChoiceMenu = document.getElementById("pets"); 
	
	var userChoice = petChoiceMenu.value; 
	
	// now request form contents via Ajax 
	var ajax = new XMLHttpRequest();
	ajax.responseType = "document"; 
	ajax.overrideMimeType("text/xml"); 
	
	ajax.onreadystatechange = function()
		{
			if (ajax.readyState == 4)
			{
				if (ajax.status == 200)
				{
					// request sends back query results within 
					// various input elements -- get their contents 
					// and build input fields 
					
					// remember: even though there's only one name, this still
					// returns an array 
					var nameElements = 
						ajax.responseXML.getElementsByTagName("name");
					
					var nameText = 
						nameElements[0].firstChild.nodeValue; 
					
					// set placeholder of name field in form = 
					// the name that was queried from XML
					var nameField = document.getElementById("name");
					nameField.placeholder = nameText; 
				}
				else
				{
					alert("Error fetching query results: " + ajax.status 
						+ " - " + ajax.statusText); 
				}
			}
		};
	
	ajax.open("GET", "pet_info_query.php?choice=" + userChoice, true);
	ajax.send(null); 
}