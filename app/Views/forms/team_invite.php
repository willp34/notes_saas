<form action="" method="post"    class="ajax_requet"  id="teamInviteForm" > 
										
								<div class="mb-3 mt-3">
							 
							 
									 <label for="" class="form-label">Email</label>
										<div class="input-group ">
										  <span class="input-group-text" id="inputGroupPrepend">@</span>
										  <input type="text" class="form-control"  name="email" id="teame-name" aria-describedby="inputGroupPrepend" required>
																			  
										</div>
								</div>
							  
								<select class="   js-data-example-ajax"  name="users[]" multiple="multiple"   style="width: 100%"></select>
								<br />
								<input type="hidden" id="team_id" value="1">
							  <button type="submit" class="btn btn-primary">Invite</button>
						</form>
						
						
						<table id="userTable" class="table" border="1">
						  <thead>
							<tr>
							  <th>Email Address</th>
							</tr>
						  </thead>
						  <tbody>
							<!-- Rows will go here -->
						  </tbody>
						</table>