"use strict"; 

// Alex Childers
// Last modified: 2019/05/08

// when a button is clicked, fill a paragraph 
window.onload = 
	function()
	{
		// get button elements from document
		var positiveButton = document.getElementById("positive"); 
		var neutralButton = document.getElementById("neutral"); 
		var negativeButton = document.getElementById("negative"); 
		
		// when these buttons are clicked, fill a paragraph with 
		// their appropriate text 
		positiveButton.onclick = function()
		{
			loadMessage("positivity.txt"); 
		}

		neutralButton.onclick = function()
		{
			loadMessage("neutrality.txt"); 
		}

		negativeButton.onclick = function()
		{
			loadMessage("negativity.txt"); 
		}
	}

// expects a file name, returns nothing. fills a paragraph element of 
// id="forecast" with the contents of the given file 
function loadMessage(fileName)
{
	// create XMLHttpRequest object
	var ajaxReq = new XMLHttpRequest();
	
	// where the file contents will go in the document 
	var outputParagraph = document.getElementById("forecast"); 
	
	// when the XMLHttpRequest is ready, try to read in the file and place its
	// contents in the "forecast" paragraph
	ajaxReq.onreadystatechange = 
		function()
		{
			if (ajaxReq.readyState == 4)
			{
				// if status == 200, request succeeded. connect http request
				// to output paragraph 
				if (ajaxReq.status == 200)
				{
					outputParagraph.innerHTML = ajaxReq.responseText; 
				}
				// if request didn't succeed, output an error message
				else
				{
					outputTextArea.innerHTML = "Error: " + ajaxReq.status + " - "
						+ ajaxReq.statusText; 
				}
			}
		};
	
	// open the given file and send it to the page asynchronously
	ajaxReq.open("GET", fileName, true);
	ajaxReq.send(null); 
}