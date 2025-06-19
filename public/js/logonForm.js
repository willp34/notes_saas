
document.getElementById('logonForm').addEventListener('submit',LogInGetJWT_Token );


function LogInGetJWT_Token(e) {
  e.preventDefault(); // Prevent default form submission

  const formData = new FormData(e.target);
  const jsonObject = {};
   
  formData.forEach((value, key) => {
    jsonObject[key] = value;
	
  });

  fetch(e.target.action, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(jsonObject)
  })
  .then(response => response.json())
  .then(data => {
  
	 console.log('Server Response:', data.token);

    // If you intend to use the token for future requests, store it
    const token = data.token;

			 if (data.redirect) {
				window.location.href = data.redirect;
			  } else {
				console.log('Logged in:', data.user);
				// fallback redirect or show dashboard
			  }
			if ("messages" in data)
			{
				var myEl = document.createElement("div");
				// Use "className" because JavaScript "class" is a reserved keyword.
				myEl.className = "alert alert-danger alert-dismissible fade show";
				// Append it
				document.querySelector("#Show-Messages").appendChild(myEl);

				if (!!myEl) {
				  myEl.textContent = data.messages.error ;
				}
				 
				 
	
			}
			
    // Example: store the token for future use
   //jQuery.cookie('CI4J~WT',token, { expires: 7, path: '/' });
    alert('Submitted successfully');
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Submission failed');
  });
}