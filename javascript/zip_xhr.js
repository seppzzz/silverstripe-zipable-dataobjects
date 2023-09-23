
	$(document).ready(function () {

		
		// Handle the button click event
		$('.zipDownloadButton').click(function (e) {
			
			e.preventDefault();
			e.stopPropagation();
			
			var href = $(this).attr('href');
			//console.log(href);
			
			// Get the base URL from the SilverStripe template variable
			// var baseHref = '$BaseHref'; 

			// Construct the URL for the XMLHttpRequest request
			var downloadUrl = href;

			// Create a new XMLHttpRequest
			var xhr = new XMLHttpRequest();
			xhr.open('GET', downloadUrl, true);
			xhr.responseType = 'blob'; // Set responseType to 'blob' to handle binary data

			xhr.onload = function () {
				if (xhr.status === 200) {
					
					var blob = xhr.response;
					var zipName = xhr.getResponseHeader('X-Zip-Name') || 'archive.zip'; // Default name if not provided

            		saveAs(blob, zipName);
					
				} else {
					// Handle errors here
					console.log('Error triggering download');
				}
			};

			// Send the AJAX request
			xhr.send();
			
		});
		
	});
