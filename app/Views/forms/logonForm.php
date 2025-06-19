
        <!--<form action="register.php" method="post">   --->
		
		  <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">
                              User Logon
                          </h2>
						  
						  
							<form action="<?php echo base_url()?>index.php/auth/loggedin" method="post"    class="needs-validation"  id="logonForm" > 
										<div class="mb-3 mt-3">
							 
							 
									 <label for="validationCustomUsername" class="form-label">Username</label>
										<div class="input-group has-validation">
										  <span class="input-group-text" id="inputGroupPrepend">@</span>
										  <input type="text" class="form-control"  name="email" id="email" aria-describedby="inputGroupPrepend" required>
										  
										  
										  
										 
										  
										</div>
								
							  </div>
							  
							  
							  
							<div class="mb-3">
							  <label for="pwd" class="form-label">Password:</label>
							  
							  <div class="input-group   has-validation">
								<input type="password" class="form-control" id="pwd" 
									   placeholder="Enter password" name="pswd" 
									   required>
							
							  </div>
							 
							 
							</div>
							
							  <button type="submit" class="btn btn-primary">Submit</button>
						</form>
						
						
						<a href="<?php echo base_url()?>index.php/home/forgotPassword">Rsset Pasword</a>
						
						
						
					
				</div>
		</div>
						  
						  
						  
						  
						  
						  
		
		
		