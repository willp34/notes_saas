<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  
  .select2-container {
  z-index: 9999 !important;
}

 
  </style>
  
  <?php $css_generated = ENVIRONMENT === 'production' ? 'app.min.css' : 'app.css'; ?>
<link rel="stylesheet" href="<?= base_url("css/$css_generated") ?>">

  <?php
  if(isset($css)){
	 
		foreach($css as $css_style){
			
			?>
			 <link href="<?php echo base_url();?>css/<?php echo $css_style ; ?>" rel="stylesheet" >
		
			<?php
		}
  }		?>
  <link href="<?php echo base_url();?>js/jquery_raty/raty.css" rel="stylesheet" >
  
  
  
</head>
<body>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo base_url(); ?>">MySite</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link " href="<?php echo base_url();?>">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('index.php/dashboard/settings');?>">Settings</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="row">
			
			<div id="Show-Messages"></div>