
class ajax_request {
	
	constructor(e , options){
		this.action = e.target.action;
		
		this.options = options 
		this.loadData(e.target.action); 
	}
	
	getToken(){
		
	}
	getHeaders(){
		
		return {
			'Content-Type': 'application/json'
		}
	}
	serialise (e){
		
		const formData = new FormData(e.target);
		const jsonObject = {};
		formData.forEach((value, key) => {
			jsonObject[key] = value;	
		  });
	 return JSON.stringify(jsonObject);
	}
	
	
	
  fetchWith(endpoint, options = {}) {
    //const headers = this.getHeaders();
    return fetch(endpoint, {
      ...options
    }).then(res => {
      if (!res.ok) throw new Error('Token invalid or expired');
      return res.json();
    });
  }
	
		
		
  loadData(urlEndpoint ,options ={}) {
 
	/*const options ={
		method : "POST",
    headers: {
      'Content-Type': 'application/json'
    },
    body: this.data
		
		
	};
	*/ 
	//   '/api/teams'
    this.fetchWith(urlEndpoint,this.options)
      .then(data => {
        console.log(data);
        jQuery('#authorised').html(data.html);
      })
      .catch(err => {
        console.error(err);

        const myEl = document.createElement("div");
        myEl.className = "alert alert-danger alert-dismissible fade show";
        myEl.textContent = err.message || "Authentication failed.";
        document.querySelector("#Show-Messages").appendChild(myEl);

        // Optional: redirect to login
        // localStorage.removeItem('token');
        // window.location.href = '/login';
      });
  }
	
	
}