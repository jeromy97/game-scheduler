$(document).ready(function(){
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	
});

function copyToClipboard(elementId) {
	/* Get the text field */
	var copyText = document.getElementById(elementId);

	/* Select the text field */
	copyText.select();
	copyText.setSelectionRange(0, 99999); /*For mobile devices*/

	/* Copy the text inside the text field */
	document.execCommand("copy");

	/* Log the copied text */
	console.log("Copied the text: " + copyText.value);
}
