<!--<form action="register.php" method="post">   --->
		
		  <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">
                              Add Team
                          </h2>
						  
						  
							<form action="<?php echo base_url()?>index.php/api/teams" method="post"    class=""  id="teamForm" > 
										
								<div class="mb-3 mt-3">
							 
							 
									 <label for="" class="form-label">Team Name</label>
										<div class="input-group ">
										  <span class="input-group-text" id="inputGroupPrepend">@</span>
										  <input type="text" class="form-control"  name="team_name" id="teame-name" aria-describedby="inputGroupPrepend" required>
																			  
										</div>
								</div>
							  
							
							  <button type="submit" class="btn btn-primary">Add Team</button>
						</form>
								
				</div>
		</div>
				