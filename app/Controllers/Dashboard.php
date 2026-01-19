<?php 
namespace App\Controllers;


use App\Libraries\Huffman\Huffman;
use App\Libraries\Thresholding\Image_Thresholding ;
class Dashboard extends BaseController{
	
	private $data = null;
	public function  __construct()
	{
		$this->data['modules']= array( "src/Ajax_service.js", "src/Ajax_form.js"  ) ; 
        $this->data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js" ,"text_stats.js");
	}
	
	 public function index()
    {
		//echo ENVIRONMENT;	
		$this->data["css"] = array("Notepad.css");
		$this->template('huffman_display',$this->data);
    }
	
	
	public function image_thresholding(){
		
		 $this->data["css"] = array("Notepad.css");
		 array_push( $this->data['js'],"filtering/image_filtering.js");
		//$thresholdLib = new Image_Thresholding();
		//$path = $thresholdLib->Ostu_Thresholding("DSC_0131.jpg");
		//echo "Thresholded image saved at: " . $path;
		$this->template('image_filtering',$this->data);
	}
	
	public function settingsPage(){
		$this->data['modal_Header'] = "2FC";
		$this->data['modal_Form'] = " ";
		$this->template('settings',$this->data);
		
	}
	
	}