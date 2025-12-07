import ToastQueue from './ToastQueue.js' ;
 export function updatePasswordStrenth(password) {
	   
			//console.log("This is ben used");
            const strongPasswordRegex = 
                  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            

            // Check each condition and update the corresponding label
            document.getElementById('minLength').innerHTML = 
                  password.length >= 8 ?
                '<i class="bi bi-check text-success"></i> Minimum 8 characters' :
                '<i class="bi bi-x text-danger"></i> Minimum 8 characters';
            document.getElementById('uppercase').innerHTML = 
                  /[A-Z]/.test(password) ?
                '<i class="bi bi-check text-success"></i> At least one uppercase letter' :
                '<i class="bi bi-x text-danger"></i> At least one uppercase letter';
            document.getElementById('lowercase').innerHTML = 
                  /[a-z]/.test(password) ?
                '<i class="bi bi-check text-success"></i> At least one lowercase letter' :
                '<i class="bi bi-x text-danger"></i> At least one lowercase letter';
            document.getElementById('symbol').innerHTML = 
                  /[@$!%*?&#]/.test(password) ?
                '<i class="bi bi-check text-success"></i> At least one symbol (@$!%*?&#)' :
                '<i class="bi bi-x text-danger"></i> At least one symbol (@$!%*?&#)';

			const msg = document.getElementById('errorMessage');
            // Check overall validity and update the error message
			
			msg.textContent = strongPasswordRegex ? "Strong Password"  : "Weak Password";
			
			msg.classList.toggle('alert-success', strongPasswordRegex);
			msg.classList.toggle('alert-danger', !strongPasswordRegex);
           
        }
		
		
		
	/*
	*   The API Response Handler
	*/

export function handleApiResponse(data){
	
	if (data.status === "error") {
        throw new Error(response.message);
    }
	
	if(data.html){
		document.querySelector('#authorised').innerHTML = data.html;
	}
	
	if(data.message) showToast(data.message, "success");
	
	if(data.error) showToast(data.error,"danger");
	
	if(data.users_in_Team){
		const tbody = document.querySelector("#userTable tbody");
		tbody.innerHTML = "";
		data.users_in_Team.forEach(user => {
			const tr = document.createElement("tr");
			tr.innerHTML  = `<td>${user.user_email}</td>`;
			tbody.appendChild(tr);
		})
	}
	
	if(data.token){
		 // If you intend to use the token for future requests, store it
		 const token = data.token;
	}
	
	if (data.redirect) {
				window.location.href = data.redirect;
			  }
}

/*
	*   The show Alert that display messagews to screen
	*/

 export function showAlert(msg, type="info"){
	const el = document.createElement("div");
	el.className = `alert alert-${type} alert-dismissible fade show` ;
	el.textContent = msg ;
	document.querySelector("#Show-Messages").appendChild(el);
}


export function showToast(message , type="info"){
	ToastQueue.push(message,type);
}	
/*
function oldToast(){
	const toastId = "t"+Date.now();
	
	const bg ={
		success: "bg-success",
		danger: "bg-danger",
		warning: "bg-warning text-dark",
		info: "bg-info text-dark"
	}[type] || "bg-secondary";  
	
	const html = `
        <div id="${toastId}" class="toast align-items-center text-white ${bg} border-0 mb-2" 
             role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
	
	const container =document.getElementById("toastArea");
	container.insertAdjacentHTML("beforeend",html);
	
	const toastElem = document.getElementById(toastId);
	const toast = new bootstrap.Toast(toastElem,{delay: 3500});
	
	toast.show();
}
*/

export function handleApiError(error){
	//console.error("API ERROR: ", error);
	
	// Network issues
	if(error.message === "Failed to fetch"){
		showToast("Network connection failed. Check your internet connect.","danger");
		return;
	}
	
	// Token expired or unathorised
	
	if(error.status === 401){
		showToast("Session expired. Please log in again.","warning");
		window.location.href= "/login";
		return ;
	}
	//forbidden
	if(showToast.status ===403){
		showToast("You are not allowed to perform this task. ","danger");
		return ;
	}
	
	// validation erros from backend (CI4 Form Validaton)
	
	if(error.status ===422 && error.errors){
		
		Object.entries(error.errors).forEach(([field, message]) =>{
			const input = document.querySelector(`[name="${field}"]`);
			if(input){
				input.classList.add("is-invalid");
				const feedback = input.nextElementSibling ;
				if(feedback) feedback.textContent = message;
			}
		});
			return ;
	}
	
	// server error 
	
	if(error.status  >= 500){
		
		showToast("Server error. Try again later ","danger") ;
		return ;
	}
	
	/// fall back
	
	showToast(error.message || "Unknown error occured.","danger");
	
} 

