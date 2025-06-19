
        <!--<form action="register.php" method="post">   --->
		
		  <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">
                              User Registration
                          </h2>
						  
						  
							<form action="<?php echo base_url()?>index.php/api/addUser" method="post"    class="needs-validation"  id="registerForm" novalidate > 
										<div class="mb-3 mt-3">
							 
							 
									 <label for="validationCustomUsername" class="form-label">Username</label>
										<div class="input-group has-validation">
										  <span class="input-group-text" id="inputGroupPrepend">@</span>
										  <input type="text" class="form-control   isvalid  email" placeholder="Enter email"  name="email" id="email" aria-describedby="inputGroupPrepend" required>
										  
										  <div class="invalid-feedback">
											Please choose a username.
										  </div>
										  
										 
										  
										</div>
								<!--<label for="email" class="form-label">Email:</label>
								<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
							  -->
							  </div>
							  
							  
							  
							<div class="mb-3">
							  <label for="pwd" class="form-label">Password:</label>
							  
							  <div class="input-group   has-validation">
								<input type="password" class="form-control  isvalid" id="pswd" 
									   placeholder="Enter password" name="pswd" 
									   oninput="validatePassword(this.value)" required>
								<button class="btn btn-outline-secondary" type="button" id="togglePassword">
								  <i class="bi bi-eye"></i>
								</button>
							  </div>

							  <div class="invalid-feedback">
								Password must be at least 8 characters.
							  </div>
							</div>
							<div class="mb-3">
							
									<label for="confirmPassword" class="form-label">Confirm Password:</label>
									<input type="password" class="form-control" id="confirmPassword" placeholder="Enter password" required>
									<div class="invalid-feedback">
									  Passwords do not match.
									</div>
							</div>
							  <button type="submit" class="btn btn-primary">Submit</button>
						</form>
						
						
						
						
						
						
						<div class="form-group">
                            <ul>
							  <li id="minLength"><i class="bi bi-x text-danger"></i> Minimum 8 characters</li>
							  <li id="uppercase"><i class="bi bi-x text-danger"></i> At least one uppercase letter</li>
							  <li id="lowercase"><i class="bi bi-x text-danger"></i> At least one lowercase letter</li>
							  <li id="symbol"><i class="bi bi-x text-danger"></i> At least one symbol (@$!%*?&)</li>
							</ul>
                        </div>
						
						 <div id="errorMessage" class="font-weight-bold
                          alert "></div>
				</div>
		</div>
						  
						  
						  
						  
						  
						  
		
		
		