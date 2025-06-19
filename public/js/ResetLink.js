document.getElementById('resetForm').addEventListener('submit',resetLink );
   
   
     function resetLink(e){
		 
	
		 e.preventDefault();
	   	// add ajax here
		var action = event.target.action;
	   alert("reset pasword link"+ action);
	   
	   const formData = new FormData(e.target);
		const jsonObject = {};
		formData.forEach((value, key) => {
			jsonObject[key] = value;	
		  });
		  
	   const options ={
			method : "POST",
			body: JSON.stringify(jsonObject)
		};
		reset_link = new ajax_request(event, options);
	 }