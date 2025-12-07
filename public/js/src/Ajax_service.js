import ToastQueue from './ToastQueue.js' ;
export default class ApiService{
	
	constructor(token = null){
		this.token = token || jQuery.cookie('CI4J~WT') || null;
	}
	
	buildHeaders(extra = {}){
		const headers = {
			"Accept" : "application/json",
			...extra
		};
		// Add JSON header only if sending JSON 
		if(extra['Content-Type']){
			
			headers['Content-Type' ] = extra['application/json'];
		};
		// Only add Authorization if token exists
		if (this.token) {
			headers['Authorization'] = 'Bearer ' + this.token;
		}
		
		return headers ;
	}
	
	async request({url, method= 'GET', data=null, headers= {} }){
		 
		
		const options = {
			 method ,
			 headers: this.buildHeaders(headers)
		 };
		 
		 // if data exists
		 
		 if(data){
			 options.body = JSON.stringify(data);
			 options.headers['Content-Type'] = 'application/json';
			 }	
			
			let response
			
			 try {
				 response = await fetch(url, options);
			 }
			 catch(networkError){
				 // Network offline, server unreachable, CORS, timeout
				ToastQueue.push("Network failure — check your connection.", "danger");
				throw new Error("Network error");
			}
			 
			 let json ;
			 
			 try{
				 json = await response.json();
			 }catch{
				  ToastQueue.push("Invalid server response.", "danger");
				  throw new Error("Invaid JSON");
			 }
			 // Handle HTTP error codes
			if (!response.ok) {
				
				const msg = json.messages.error ||  json.error || json.message || `HTTP ${response.status}`;
				console.warn("error:  ",json.messages.error );
				//ToastQueue.push(msg, "danger");
				throw new Error(msg);
			}
			 
			 // Auto-toast success messages
			if (json.message) {
				ToastQueue.push(json.message, "success");
			}

			return json;
			 
			
	}
}










