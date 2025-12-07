<?php  
namespace App\Libraries\Thresholding ;

class Image_Thresholding {
	
	public function Ostu_Thresholding($filename){
		
		$path = FCPATH . $filename ;

        if (!file_exists($path)) {
            throw new \Exception("Image not found: " . $path);
        };
		
		
		$img = new \Imagick($path);
		$img->setImageColorspace(\Imagick::COLORSPACE_GRAY);
		
		$histogram = $img->getImageHistogram();
		$totalPixels = $img->getImageWidth() * $img->getImageHeight();
		
		$sum = 0;
		
		for($i=0; $i <256; $i++){
			$sum += $i * $histogram[$i]->getColor()['r'];
		}
		
		$sumB=0;
		$wB =0;
		$maxVariance = 0;
		$threshold  =0;
		
		for($i =0; $i <256; $i++){
			
			$wB += $histogram[$i]->getColor()['r'];
			
			if($wB ==0) continue;
			
			$wF = $totalPixels- $wB;
			
			if($wF ==0) break;
			
			$sumB += $i * $histogram[$i]->getColor()['r'];
			
			$meanB = $sumB/ $wB;
			$meanF = ($sum - $sumB)/$wF;
			$variance = $wB * $wF *pow($meanB-$meanF,2);
			
			if($variance > $maxVariance){
				$maxVariance = $variance;
				$threshold=$i;
			}
		}
		
		$img->thresholdImage($threshold/255);
		// Ensure output folder exists
        $outputFolder = FCPATH . "thresholding/";
        if (!is_dir($outputFolder)) {
            mkdir($outputFolder, 0755, true);
        }

        // Save image (keep original filename)
        $outputPath = $outputFolder . basename($filename);
		
		$img->setImageFormat('jpeg'); // save as JPEG
        $img->writeImage($outputPath);
        $img->destroy();
        return $outputPath;
	}
}
