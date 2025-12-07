
  <h2>Image filtering</h2>
  <div class="row">
  
		<!--<div class="col-6">
		
		  <img id="img_src" src="<?= base_url('DSC_0131.jpg') ?>" alt="Thresholded Image" width="100%"    />
		</div>
		<div class="col-6">
		 
		  <canvas id="cv"></canvas>
		</div>
	</div> !-->
	<div id="compare-wrapper" class="position-relative overflow-hidden">
    <img id="img_src" src="<?= base_url('DSC_0131.jpg') ?>" class="img-fluid d-block w-100" alt="">

    <div id="canvas-overlay" class="position-absolute top-0 start-0 h-100 overflow-hidden">
        <canvas id="cv"></canvas>
    </div>

    <div id="slider-handle"
         class="position-absolute top-0 h-100"
         style="width:1px; background:[; cursor:ew-resize; z-index:10;">
    </div>
</div>
	<form action="/action_page.php">
		<div class="form-check    form-check-inline">
		  <input type="radio" class="form-check-input" id="radio1" name="optradio" value="Pixel manipulation" checked>Pixel manipulation
		  <label class="form-check-label" for="radio1"></label>
		</div>
		<div class="form-check form-check-inline">
		  <input type="radio" class="form-check-input" id="radio2" name="optradio" value="Floyd">Floyd Dithering
		  <label class="form-check-label" for="radio2"></label>
		</div>
			<div class="form-check form-check-inline">
		  <input type="radio" class="form-check-input" id="radio3" name="optradio" value="atkinson">Atkinson Dithering
		  <label class="form-check-label" for="radio3"></label>
		</div>
		
			<div class="form-check form-check-inline">
		  <input type="radio" class="form-check-input" id="radio5" name="optradio" value="threshold">Threshold Dithering
		  <label class="form-check-label" for="radio5"></label>
		</div>
		<div class="form-check form-check-inline">
		  <input type="radio" class="form-check-input" disabled>Option 4
		  <label class="form-check-label"></label>
		</div>
		<div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
</form>
</div>