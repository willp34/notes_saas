<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Team name</th>
      <th scope="col">Role</th>
      <th scope="col">Email</th>
	  <th scope="col">action</th>
	  <th scope="col">Number of users</th>
    </tr>
  </thead>
  <tbody>
  <?php
	foreach($teams as $key => $team)
		  { 
			  ?>
		
		  <tr>
			  <th scope="row">1</th>
			  <td><?php echo $team['team_name'] ;   ?></td>
			  
			  
			   <?php  if($type == "created"){ ?>
			   
				  
				  <td><?php // echo $team['role'] ;   ?></td>
				  <td><?php //echo $team['user_email'] ;   ?></td>
				  <td> <button type="button" class="btn btn-link"    ><a href="<?php echo base_url("index.php/api/invite/".$team["id"]); ?>" data-id="<?php echo $team["id"]; ?>" data-bs-toggle="modal" data-bs-target="#myModal"  class="inviteForm" >Invite</a></button></td>
				  
				 
				  <td><?php echo $team['number_of_members'] ;   ?></td>
			  
			  <?php  }
			  
			  else{ 
			  ?>
				<td><?php echo $team['role'] ;   ?></td>
				<td><?php //echo $team['user_email'] ;   ?></td>
				<td><button type="button" class="btn btn-link"    ><a href="#" data-id="<?php echo $team["id"]; ?>"   class="Add-Note" >Add Note</a></button></td>
				<td></td>
			  <?php }
			  ?>
			</tr>
		  
		  <?php
		  }
		  ?>
    
   
  </tbody>
</table>
<div id="notes">
  <p>NOTES</p>
  
  <form action="<?php echo base_url()?>index.php/api/notes" method="post"      id="noteForm" > 
										
								<div class="mb-3 mt-3">
							 
							 
									 <label for="" class="form-label">Note</label>
										<div class="input-group ">
										
										  <textarea type="text" class="form-control" placeHolder="Note jotter" name="note_content" id="note-content" aria-describedby="inputGroupPrepend" rows="4"></textarea>
																			  
										</div>
								</div>
							  
								<input type="hidden"  name="teamId" value="" id="teamField" />
							  <button type="submit" class="btn btn-primary">Add Note</button>
						</form>
  
  
</div>