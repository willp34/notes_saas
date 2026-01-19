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

jQuery(document).on("click", "a.Add-Note, a.inviteForm", function (e) {
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
		  
		 //2FA front end
		 
		 const toggle2FA = document.getElementById('toggle2FA') ;
		 const myModalEl =document.getElementById("myModal") ;
		toggle2FA.addEventListener('change', modalDisplay)
   
  async function  modalDisplay(e){
	   const myModal =new bootstrap.Modal(myModalEl);
			if(e.target.checked){
					console.log("2fa toggle works");
					
					myModal.show();
					setup2FA();
			}
   }
   
   async function setup2FA(){
	   const api = new ApiService();
		try{
			const response = await api.request({
			url: 'http://localhost/notes-saas/public/index.php/security/enable2fa',
			method: "POST",
			data : null
			});
			
			console.log("Response: ", response);
			// SHOW Qr in a modal 
			showQRModel(response.qr_url);
			
		
			
		}catch( err)
		{	
			console.error("wwww  Caught error:", err);
				const msg = err.message || "Unknown error occurred";
				handleApiError(err);
			}
   }
   //Modal display function
  function showQRModel(qrUrl) {
    const container = document.querySelector('.modal-body');
    container.innerHTML = '';

    const qrSlot = document.createElement('div');
    qrSlot.id = 'qr-slot';

    const codeSlot = document.createElement('div');
    codeSlot.id = 'code-slot';

    const statusSlot = document.createElement('div');
    statusSlot.id = 'status-slot';

    const qrImageUrl =
        'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' +
        encodeURIComponent(qrUrl);

    const img = document.createElement('img');
    img.src = qrImageUrl;

    qrSlot.appendChild(img);

    const input = document.createElement('input');
    input.id = 'otp';
    input.placeholder = 'Enter 6-digit code';
    input.maxLength = 6;

    const btn = document.createElement('button');
    btn.textContent = 'Confirm';
    btn.onclick = confirm2FA;

    codeSlot.appendChild(input);
    codeSlot.appendChild(btn);

    container.appendChild(qrSlot);
    container.appendChild(codeSlot);
    container.appendChild(statusSlot);
}

function confirm2FA() {
    const code = document.getElementById('otp').value;

    fetch('http://localhost/notes-saas/public/index.php/security/confirm2fa', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json',
				 'Authorization': 'Bearer ' +  jQuery.cookie('CI4J~WT') },
        body: JSON.stringify({ code })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('status-slot').textContent =
            data.status === 'ok'
                ? '2FA enabled successfully ✔'
                : 'Invalid code';
    });
}