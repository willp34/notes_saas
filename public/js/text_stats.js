
jQuery(document).on("input","textarea" , function() {
	console.log("text ststs  ", jQuery(this).hasClass("number-of-Words"));
	
	if(jQuery(this).hasClass("number-of-Words")){
		 
		const text  = jQuery(this).val().trim();
		const chars = text.length;
		const words = text ? text.split(/\s+/).length : 0;

		/*console.log(
			"Input text:", text,
			"Characters:", chars,
			"Words:", words
		);*/
		
		// Build the Bootstrap row + columns dynamically
		const infoBox = jQuery(`
			<div class="row mt-3">
		   
				<div class="col-auto"><strong>Characters:</strong> ${chars}</div>
				<div class="col-auto"><strong>Words:</strong> ${words}</div>
			</div>
		`);

		// Remove old info and insert the new one
		jQuery(".output-container").html(infoBox);
		}
})
