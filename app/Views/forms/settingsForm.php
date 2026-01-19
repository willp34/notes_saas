<!--<form action="register.php" method="post">   --->
		
		  <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">
                              Settings 
                          </h2>
						  
						  
							<form action="<?php echo base_url()?>index.php/security/enable2fa" data-ajax method="post"  class="ajax_requet"   id="teamForm" > 
										
								<div class="mb-3 mt-3">
							 
							 
									 <label for="" class="form-label">Two factor Authentication</label>
										<div class="input-group ">
										  <div class="form-check form-switch">
											  <input class="form-check-input" name="2fa" type="checkbox" role="switch" id="toggle2FA" >
											  <label class="form-check-label" for="flexSwitchCheckChecked">2 factor Authentication</label>
											</div>							  
										</div>
								</div>
							  
							
							  <button type="submit" class="btn btn-primary">Add Team</button>
						</form>
								
				</div>
		</div>
				