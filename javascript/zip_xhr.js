

document.addEventListener("DOMContentLoaded", function () {
    var buttons = document.querySelectorAll(".zipDownloadButton");

    buttons.forEach(function (button) {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            var href = this.getAttribute('href');

            
            // Get the base URL from the SilverStripe template variable
			//var baseHref = '$BaseHref'; // Ensure this is properly rendered in your template

            // Construct the URL for the AJAX request
            var downloadUrl =  href;

            // Create a new XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open('GET', downloadUrl, true);
            xhr.responseType = 'blob'; // Set responseType to 'blob' to handle binary data

            xhr.onload = function () {
                if (xhr.status === 200) {
                    var blob = xhr.response;
                    var zipName = xhr.getResponseHeader('X-Zip-Name') || 'archive.zip'; // Default name if not provided
					var zipSize = xhr.getResponseHeader('X-Zip-Size');
					
					var userConfirmation = confirm(ss.i18n.sprintf(
						ss.i18n._t('ZIPABLE.CONFIRMATION_TEXT'),
						(zipSize / 1024).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
					));
					
           			if (userConfirmation) {
						saveAs(blob, zipName);
           			} else {
						alert(ss.i18n._t('ZIPABLE.CANCEL_TEXT'));
           			}

                } else {
                    // Handle errors here
                    console.log('Error triggering download');
                }
            };

            // Send the AJAX request
            xhr.send();
        });
    });
});

