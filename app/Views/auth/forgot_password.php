

  <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">  Reset your pssword </h2>
						  
							<form action="<?php echo base_url()?>index.php/auth/sendResetLink" method="post"    class="needs-validation"  id="resetForm" > 
										<div class="mb-3 mt-3">
							 
							 
									 <label for="validationCustomUsername" class="form-label">Username</label>
										<div class="input-group has-validation">
										  <span class="input-group-text" id="inputGroupPrepend">@</span>
										  <input type="text" class="form-control"  name="email" id="email" aria-describedby="inputGroupPrepend" required>
										</div>
			
							  </div>
							
							  <button type="submit" class="btn btn-primary">Submit</button>
						</form>
						
				</div>
		</div>