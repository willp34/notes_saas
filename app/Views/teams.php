
   
		<h2>My Teams</h2>

		<div id="authorised">  </div>
			
		<?php 
		
		echo view('tables/showTeams',["teams"=>$teamsBelongTo, "type"=>"created"] );
		echo view("forms/teamForm") ; 
		echo view('tables/showTeams',["teams"=>$memberTeams, "type" =>"member" ] );
		?>
	  <div id="notes">
	  <p>NOTES</p>
	  
	  <form action="<?php echo base_url()?>index.php/api/notes" method="post" class="ajax_requet"      id="noteForm" > 
											
						<div class="mb-3 mt-3">
								<label class="form-label">Note</label>
								<div class="input-group">
									<textarea id="Notecontent" 
											  class="form-control number-of-Words"
											  placeholder="Note jotter" 
											  name="note_content"
											  rows="4"
											  required></textarea>
								</div>
							</div>
								  
									<input type="hidden"  name="teamId" value="" id="teamField" />
								  <button type="submit" class="btn btn-primary">Add Note</button>
							</form>
	  <div  class="output-container"></div>
	  
	</div>