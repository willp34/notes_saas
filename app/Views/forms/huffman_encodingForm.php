	<form action="<?php echo base_url()?>index.php/encoding/huffman"  data-ajax 	method="post"    class="ajax_requet"  id="huffmanForm" > 
										
				<div class="mb-3 mt-3"> 
					<p>Add Text</p>
					<div class="input-group ">
										
						  <textarea type="text" class="form-control number-of-Words" placeHolder="Text to encode...." name="encoded_phrase" id="huffman-content" aria-describedby="inputGroupPrepend" rows="10"></textarea>
															  
					</div>
				</div>
							  
				
				<button type="submit" class="btn btn-primary">Encode using Hufffman</button>
	</form>
  <div  class="output-container"></div>