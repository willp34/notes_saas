

import {updatePasswordStrenth} from './Ajax_helpers.js' ;
import {handleApiResponse} from './Ajax_helpers.js' ;
import {showAlert} from './Ajax_helpers.js' ;
import {showToast} from './Ajax_helpers.js' ;
import {handleApiError} from './Ajax_helpers.js' ;
import FormValidator from './FormValidator.js' ;
import ApiService from './Ajax_service.js' ;
// Real time (On  input)

jQuery(document).on("input", '.isvalid', function() {

 var dInput = this.value;
    
	
	if(jQuery(this).hasClass("email")){
		//console.log("Email  ",dInput);  
		FormValidator.validateEmail(this);
	}
	
	if(jQuery(this).hasClass("password")){
		//console.log("Password");
		updatePasswordStrenth(this.value);
	}
})

document.addEventListener("submit", async function(e){
	
	 //const form = e.target;
	
	const form =  e.target.closest("form[data-ajax]");
	
	if(!form) return ;
	  /* ----------------------------------------
     * 1. REGISTER FORM SUBMIT VALIDATION + AJAX
     * ---------------------------------------- */
	
	if(form.id === "registerForm"){
		e.preventDefault();
		const email = form.querySelector("#email");
		const pass  = form.querySelector("#pswd");
		const confirm = form.querySelector("#confirmPassword");
		
		let valid = true;
		
		if(!FormValidator.validateEmail(email)) valid=false;
		
		if(!FormValidator.validatePasswordStrength(pass)) valid = false; 
		
		 if (!FormValidator.validatePasswordMatch(pass, confirm)) valid = false;

        if (!valid) return;
		
		// Convert FormData → JSON
		
		const data = Object.fromEntries(new FormData(form).entries());
		const api = new ApiService();
		
		try{
			
			const response = await api.request({
				url : form.action,
				method : form.method || "POST",
				data: data,
			})
			
			console.log("Response:", response);
			handleApiResponse(response);
			
			//handleApiResponse(res);
		} catch (err){
			  console.error("Caught error:", err);
			  handleApiError(err);
		
		}
		
	}
})

 /* ----------------------------------------
     * 2. PASSWORD VISIBILITY (EYE ICON)
     * ---------------------------------------- */
    document.getElementById("togglePassword")?.addEventListener("click", function () {
        const password = document.getElementById("pswd");
        const icon = this.querySelector("i");

        if (password.type === "password") {
            password.type = "text";
            icon.classList.replace("bi-eye", "bi-eye-slash");
        } else {
            password.type = "password";
            icon.classList.replace("bi-eye-slash", "bi-eye");
        }
    });
