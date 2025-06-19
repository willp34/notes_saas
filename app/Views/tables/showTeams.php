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
				<td></td>
				<td></td>
			  <?php }
			  ?>
			</tr>
		  
		  <?php
		  }
		  ?>
    
   
  </tbody>
</table>