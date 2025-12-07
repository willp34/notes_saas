
	export default class ToastQueue {
		
		static maxVisible = 3;
		static queue =[] ;
		static active = [];
		
		static push(message, type="info"){
			const toastObj = {message,type};
			this.queue.push(toastObj);
			this.processQueue()
		}
		
		static processQueue(){
			if(this.active.length >= this.maxVisible) return;
			if(this.queue.length === 0) return;
			
			const toastData = this.queue.shift();
			this.showToast(toastData.message, toastData.type);
		}
		
		static showToast(message, type){
			
			const container =document.getElementById("toastArea");
			
			//Detect dark mode
			const dark = window.matchMedia("(prefers-color-scheme: dark)").matches;
			
			const bgClass = {
				success: dark ? "bg-success text-light" : "bg-success text-white",
				danger: dark ? "bg-danger text-light" : "bg-danger text-white",
				warning: dark ? "bg-warning text-dark" : "bg-warning text-dark",
				info: dark ? "bg-info text-dark" : "bg-info text-dark"
        }[type] || (dark ? "bg-secondary text-light" : "bg-secondary text-white");
		
		  // ICONS
        const iconClass = {
            success: "bi-check-circle",
            danger: "bi-exclamation-octagon",
            warning: "bi-exclamation-triangle",
            info: "bi-info-circle"
        }[type] || "bi-dot";
		// Create toast element 
		
		const toastEl = document.createElement("div");
		toastEl.className = `toast align-items-center ${bgClass}`;
		toastEl.setAttribute("role","alert");
		toastEl.setAttribute("data-bs-delay","3500");
		
		toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${iconClass} me-2"></i>
                    ${message}
                </div>
                <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
		container.appendChild(toastEl) ;
		
		const toast = new bootstrap.Toast(toastEl);
		
		this.active.push(toast);
		
		// When toast hides → remove it → process next in queue
		
		toastEl.addEventListener("hidden.bs.toast", ()=>{
			toastEl.remove();
			this.active = this.active.filter(t => t !== toast);
			this.processQueue();
		})
		toast.show();
		}
	}