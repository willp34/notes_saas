import ApiService from './Ajax_service.js' ;
import {handleApiResponse} from './Ajax_helpers.js' ;
import {handleApiError} from './Ajax_helpers.js' ;
import {showAlert} from './Ajax_helpers.js' ;
import {showToast} from './Ajax_helpers.js' ;

document.addEventListener("submit" ,process_ajax_request)
function validateForm(form){
	
	if(form.id === "notForm"){
			
			if (!jQuery("#noteForm #teamField").val()) {	
				  showAlert("Team Id not selected","Danger");
				  return false;}
		  
			// NOTE CONTENT VALIDATION
				const noteText = jQuery("#Notecontent").val().trim();
				if (noteText === "") {
					showToast("Please add a note", "Danger");
					return false;
				}
		}
		return true;
}
async function process_ajax_request(e) {
	
	const form =  e.target.closest("form[data-ajax]");
	
	if(!form) return ;
	if(form.classList.contains("ajax_requet")){
		
		e.preventDefault();
		
		
     
	console.log("Processing");
		
		const data = Object.fromEntries(new FormData(form).entries());
		const api = new ApiService();
		try{
			const response = await api.request({
			url: form.action,
			method: form.method || "POST",
			data : data
			});
			
			console.log("Response: ", response);
			handleApiResponse(response)
		}catch( err)
		{	
			console.error("wwww  Caught error:", err);
				const msg = err?.message || "Unknown error occurred";
				handleApiError(err);
			}
		
	}
}

jQuery(document).on("click", "a", function (e) {
    e.preventDefault();
	const link  = jQuery(this);
	 
	 if(link.hasClass("Add-Note"))
	 {
		  var teamID = link.data("id");
		  // Set the hidden input value
		 jQuery("form #teamField").val(teamID);
		  
	 }
	  if(link.hasClass("inviteForm")){
		  var teamID = link.data("id");
		  loadUsersForTeam(teamID);
	  }

})
 //jQuery(".inviteForm").click(loadUsersForTeam );
      async function loadUsersForTeam(teamID){
		  console.log("load users, ", teamID);
		    //  bring data accross to form 
			var invite_link = jQuery(this).attr('href')
			//var teamID = jQuery(this).data("id");
			jQuery('#team_id').val(teamID) ;
			jQuery('#teamInviteForm').attr('action', invite_link);
		   // call ajax api
		   
		   const api = new ApiService();
		   const url =  `http://localhost/notes-saas/public/index.php/api/getUsersforTeam/${teamID}`;
			api.request({
				url: url
			}).then( response => {
				console.log("Response: ", response);
				handleApiResponse(response)
			}).catch( err => {
				console.error("wwww  Caught error:", err);
				  const msg = err?.message || "Unknown error occurred";

				}
			)
		  }
   