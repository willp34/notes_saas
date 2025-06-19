 
 
const token = jQuery.cookie('CI4J~WT'); // get token from storagefunction getCookie(name) {



  document.getElementById('teamForm').addEventListener('submit',ajaxHasndler );
   
   
   
   function   ajaxHasndler(e){
	   e.preventDefault();
	   	// add ajax here
		var action = e.target.action;
	 
	   
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
					jsonObject[key] = value;
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
   
   
   //Modals  
   
   jQuery(".inviteForm").click(inviteModalPopup );
   
   function inviteModalPopup(){
	  var invite_link = jQuery(this).attr('href')
	  var teamID = jQuery(this).data("id");
	  var url = "http://localhost/notes-saas/public/index.php/api/getUsersforTeam/"+teamID;
	jQuery('#team_id').val(teamID) ;
	  jQuery('#teamInviteForm').attr('action', invite_link);
	  jQuery("#userTable tbody").empty();
	  jQuery.ajax({
            type: "get",
            url: url,
			headers : {
					'Content-Type': 'application/json',
					'Authorization': 'Bearer ' + token
					},
            data: null,
            processData: true,
            contentType: "application/json",
            dataType: "json",
            success: function(response){
				  jQuery.each(response.users_in_Team, function (index, item) {
					  var row = jQuery("<tr>");
					  row.append(jQuery("<td>").text(item.user_email));
					  jQuery("#userTable tbody").append(row);
					});
			},
            error: function (xhr, status, error) {
                console.error('Error ',xhr.status ,' : ',status,' ' , xhr.responseText);
            }
        });
   }
   
  jQuery(".ajax_requet").submit(ajaxHasndler); 
   
  
   
   
   
     