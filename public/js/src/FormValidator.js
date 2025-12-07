import {updatePasswordStrenth} from './Ajax_helpers.js'
 
 export default class FormValidator {
	
	static validateEmail(emailField){
		const value = emailField.value.trim();
		const strongEmailRegex= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
		
		if(!strongEmailRegex.test(value)){
			
			email.classList.add('is-invalid');
			email.classList.remove('is-valid');
		    return false;
		}
		
	  //email.classList.remove('is-invalid');
	  //email.classList.add('is-valid');
	  email.classList.replace('is-invalid', 'is-valid' );
	  return  true;
		
	}
	
	static validatePasswordMatch(pw, confirmPassword){
		
		if (pw.value !== confirmPassword.value || confirmPassword.value === '') {
			confirmPassword.classList.add('is-invalid');
			confirmPassword.classList.remove('is-valid');
			return false;
		}
		//confirmPassword.classList.remove('is-invalid');
		//confirmPassword.classList.add('is-valid'); 
		confirmPassword.classList.replace('is-invalid', 'is-valid' );
		return true;
	
	}
	
	static validatePasswordStrength(passwordInput){
		const password = passwordInput.value;
		const strongPasswordRegex =
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}$/;
		updatePasswordStrenth(password)
		
		if(!strongPasswordRegex){
			passwordInput.classList.add("is-valid")
			return false;
		}
		passwordInput.classList.replace('is-invalid', 'is-valid' );
		return true ;
	}
	
}

