

<h2>  Reset Password  </h2>

<p><?php   echo $token  ?></p>


		  <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">
                              Reset Password
                          </h2>
						  
						  
							<form action="<?php echo base_url()?>index.php/auth/loggedin" method="post"    class="needs-validation"  id="logonForm" > 
										
							  
							  
							  
							<div class="mb-3">
							  <label for="pwd" class="form-label">Password:</label>
							  
							  <div class="input-group   has-validation">
								<input type="password" class="form-control" id="pwd" 
									   placeholder="Enter password" name="pswd" 
									   required>
							
							  </div>
							 
							 
							</div>
								<input type="hidden" value="<?php  echo $token ?>"/>
							  <button type="submit" class="btn btn-primary">Submit</button>
						</form>
						
						
						
					
				</div>
		</div>