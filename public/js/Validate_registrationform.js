

jQuery('.isvalid').on("input", function() {
    var dInput = this.value;
    console.log(dInput);
    //jQuery(".dDimension:contains('" + dInput + "')").css("display","block");
	
	
	if(	jQuery(this).hasClass("email")){
		//console.log("has email");
		const email = jQuery(this);
		let isValid = true;

		// Strong email regex (not perfect, but good)
		const strongEmailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
		if (!strongEmailRegex.test(email.value)) {
		  email.addClass('is-invalid');
		  isValid = false;
		} else {
		  email.removeClass('is-invalid');
		  email.addClass('is-valid');
		}
			return false ;
	}
});




 const form = document.getElementById('registerForm');

form.addEventListener('submit', function (event) {
    event.preventDefault();
    event.stopPropagation();

    const email = document.getElementById('email');
    const password = document.getElementById('pswd');
    const confirmPassword = document.getElementById('confirmPassword');

    let isValid = true;

    // Strong email regex (not perfect, but good)
    const strongEmailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
    if (!strongEmailRegex.test(email.value)) {
      email.classList.add('is-invalid');
      isValid = false;
    } else {
      email.classList.remove('is-invalid');
      email.classList.add('is-valid');
    }

    // Password length check
    if (password.value.length < 8) {
      password.classList.add('is-invalid');
      isValid = false;
    } else {
      password.classList.remove('is-invalid');
      password.classList.add('is-valid');
    }

    // Confirm password match check
    if (password.value !== confirmPassword.value || confirmPassword.value === '') {
      confirmPassword.classList.add('is-invalid');
      isValid = false;
    } else {
      confirmPassword.classList.remove('is-invalid');
      confirmPassword.classList.add('is-valid');
    }

    if (isValid) {
		
		// add ajax here
		var action = event.target.action;
		ax = new ajax_request(event);
		ax.loadData();
		//LogInGetJWT_Token(event);
		
		alert(action);
    // form.submit();
      // Here you'd typically submit the form or use AJAX
    }
  });
  
   // Function to toggle password visibility
        document.getElementById('togglePassword').addEventListener('click',
                      function () {
            const passwordInput = document.getElementById('pswd');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
  
   function validatePassword(password) {
	   
	   
            const strongPasswordRegex = 
                  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            const errorMessage = document.getElementById('errorMessage');

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

            // Check overall validity and update the error message
            if (strongPasswordRegex.test(password)) {
                errorMessage.textContent = 'Strong Password';
				 //errorMessage.classList.remove('text-danger');
                errorMessage.classList.remove('alert-danger');
				errorMessage.classList.add('alert-success');
				
                //errorMessage.classList.add('text-success');
            } else {
                errorMessage.textContent = 'Weak Password';
                //errorMessage.classList.remove('text-success');
				errorMessage.classList.remove('alert-success');
                errorMessage.classList.add('alert-danger');
                //errorMessage.classList.add('text-danger');
            }
        }

// Example starter JavaScript for disabling form submissions if there are invalid fields








function LogInGetJWT_Token(e) {
  //e.preventDefault(); // Prevent default form submission
	var action = e.target.action;
  const formData = new FormData(e.target);
  const jsonObject = {};
   
  formData.forEach((value, key) => {
    jsonObject[key] = value;
	
  });

  fetch(action, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(jsonObject)
  })
  .then(response => response.json())
  .then(data => {
  
	

    // If you intend to use the token for future requests, store it


			if ("messages" in data)
			{
				document.querySelector("#Show-Messages").innerHTML="";
				var myEl = document.createElement("div");
				// Use "className" because JavaScript "class" is a reserved keyword.
				myEl.className = "alert alert-danger alert-dismissible fade show";
				// Append it
				document.querySelector("#Show-Messages").appendChild(myEl);

				if (!!myEl) {
				  myEl.innerHTML = data.messages.error ;
				} 
				 
				 
	
			}
			 
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Submission failed');
  });
}










/*
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()  /
*/