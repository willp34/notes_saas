<div class="row g-3">
  <div class="col">
	   <div class="accordion" id="accordionProducts">

		<?php
			foreach($products as $id => $product){
				$display ="show";
				if($id>1){ $display="";}
				?>
					<div class="accordion-item">
						<h2 class="accordion-header">
						  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php  echo $id ?>" aria-expanded="true" aria-controls="collapse<?php  echo $id ?>">
							<?php  echo  $product["title"]. $id ?>
						  </button>
						</h2>
						<div id="collapse<?php  echo $id ?>" class="accordion-collapse collapse <?php echo  $display ; ?> " data-bs-parent="#accordionProducts">
						  <div class="accordion-body">
							
							<ul>
								<?php
									foreach($product["services"] as $id => $service){
										?>
										<li class="product" data-name="<?php echo $service["service_title"]  ; ?>" data-price="<?php echo $service["price"]  ; ?> ">
										<?php echo $service["service_title"]  ; ?>   <span class="price"><strong><?php echo $service["price"]  ; ?> </strong></span > <a href="#" class="add-to-cart">Add to cart</a>
										</li>
									<?php
									}
									?>
							</ul>
						  </div>
						</div>
				  </div>
				<?php
			}
		?>
		</div>
   
   
  </div>
  <div class="col">
	<div  class="shopping-cart">
		<h2>Cart</h2>
		<ul id="cart-items"></ul>
		<p>Total: £<span id="cart-total">0</span></p>
	</div>
  </div>
</div>
