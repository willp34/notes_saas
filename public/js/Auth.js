 
 
const token = jQuery.cookie('CI4J~WT'); // get token from storagefunction getCookie(name) {



  //document.getElementById('teamForm').addEventListener('submit',ajaxHasndler );
   
   
   //  document.getElementById('noteForm').addEventListener('submit',ajaxHasndler );
   
   //document.addEventListener("submit", team_and_notes );
   
   /*@
   function team_and_notes(e){
    if (e.target && (e.target.id === "teamForm" || e.target.id === "noteForm")) {
        //e.preventDefault();
        ajaxHandler(e);
    }
} */
   
   function   ajaxHandler(e){
	   e.preventDefault();
	   	// add ajax here
		var action = e.target.action;
	 
	   alert(action) ;
	   const formData = new FormData(e.target);
		const jsonObject = {};
		formData.forEach((value, key) => {
				  // Check if key already exists
				  if (jsonObject.hasOwnProperty(key)) {
					// If it's not already an array, convert it
					
					
					if (!Array.isArray(jsonObject[key])) {
					  jsonObject[key] = [jsonObject[key]];
					}
					jsonObject[key].push(value); // Add to array
				  } else {
					jsonObject[key] =value;
				  }
				});
	   const options ={
			method : "POST",
			headers: {
				'Content-Type': 'application/json',
				 'Authorization': 'Bearer ' + token
					},
			body: JSON.stringify(jsonObject)
		};
		add_team = new ajax_request(e, options);
		//ax.loadData();
   
   }
   
   
  
   
  jQuery(".ajax_requet").submit(ajaxHandler); 
   
  
   
     jQuery(document).on("click", ".Add-Note", setNoteForm_URL);
	  
	  function setNoteForm_URL(){
		  var teamID = jQuery(this).data("id");
		
    // Get the current action (original form action)
		
		  
		
		 // Set the hidden input value
        jQuery("form #teamField").val(teamID);
		
	  }
   
     