
   
		<h2>My Teams</h2>

		<div id="authorised">  </div>
			
		<?php 
		
		echo view('tables/showTeams',["teams"=>$teamsBelongTo, "type"=>"created"] );
		echo view("forms/teamForm") ; 
		echo view('tables/showTeams',["teams"=>$memberTeams, "type" =>"member" ] );
		?>
  