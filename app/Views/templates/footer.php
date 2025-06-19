
	</div>
</div>

<div class="mt-5 p-4 bg-dark text-white text-center">
  <p>Footer</p>
</div>



<?php 
     if(!(empty($modal_Header)   || empty($modal_Form)  )  ){
?>
		<!-- The Modal -->
		<div class="modal" id="myModal">
		  <div class="modal-dialog">
			<div class="modal-content">

			  <!-- Modal Header -->
			  <div class="modal-header">
				<h4 class="modal-title"><?php echo $modal_Header  ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>

			  <!-- Modal body -->
			  <div class="modal-body">
				<?php echo $modal_Form;     ?>
			  </div>

			  <!-- Modal footer -->
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			  </div>

			</div>
		  </div>
		</div>
<?php   }
?>


</body>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <?php
  if(isset($js)){
		foreach($js as $js_script){
			
			?>
			 <script src="<?php echo base_url();?>js/<?php echo $js_script ; ?>"></script>
		
			<?php
		}
  }		?>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="<?php echo base_url();?>js/userSelect2.js"></script>
</html>