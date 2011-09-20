<?php
final class Image {
    private $file;
    private $image;
    private $info;
	private $watermark;
		
	public function __construct($file) {
		if (file_exists($file)) {
			$this->file = $file;

			$info = getimagesize($file);
        
			$this->info = array(
            	'width'  => $info[0],
            	'height' => $info[1],
            	'bits'   => $info['bits'],
            	'mime'   => $info['mime'],
				'type'	 => $info[2]
        	);
        	
        	$this->image = $this->create($file);
			
			
    	} else {
      		//exit('Error: Could not load image ' . $file . '!');
    	}
	}
		
	private function create($image) {
		$mime = $this->info['mime'];
		
		if ($mime == 'image/gif') {
			return imagecreatefromgif($image);
		} elseif ($mime == 'image/png') {
			return imagecreatefrompng($image);
		} elseif ($mime == 'image/jpeg') {
			return imagecreatefromjpeg($image);
		}
		
		
    }	
	
    public function save($file, $mashlogo = true, $quality = 100) {	
		$output = $file;
		
		if((float)$this->info['width'] > 266 && $mashlogo == true)
		{
			$this->drawMashLogo();
		}
		
		switch ( $this->info['type'] ) {
		  case IMAGETYPE_GIF:
			imagegif($this->image , $output);
		  break;
		  case IMAGETYPE_JPEG:
			@imagejpeg($this->image , $output);
		  break;
		  case IMAGETYPE_PNG:
			imagepng($this->image , $output);
		  break;
		  default:
			return false;
		}
		
 	    @imagedestroy($this->image);
		@imagedestroy($this->watermark);
    }
	  
	
	public function delete($file, $use_linux_commands = false){
		if ( $use_linux_commands )
			exec('rm '.$file);
		  else
			@unlink($file);	
	}
	
	public function drawMashLogo()
	{
		//Duong dan hinh anh watermark
		$path_watermark = DIR_IMAGE."watermarklogo.png";
		
		//Ve logo water len hinh goc
		if (file_exists($path_watermark))
		{
			$filetype = strtolower(substr($path_watermark,strlen($path_watermark)-4,4));
			if($filetype == ".gif") $this->watermark = @imagecreatefromgif($path_watermark); 
			if($filetype == ".jpg") $this->watermark = @imagecreatefromjpeg($path_watermark); 
			if($filetype == ".png") $this->watermark = @imagecreatefrompng($path_watermark); 
			
			if (!empty($this->watermark))
			{
				$imagewidth = imagesx($this->image);
				$imageheight = imagesy($this->image); 
				$watermarkwidth = imagesx($this->watermark);
				$watermarkheight = imagesy($this->watermark);					
				$startwidth = 10;
				$startheight = $imageheight-63;		
				imagecopy($this->image, $this->watermark,  $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight);
			}
		}
	}  
	
	public function resize($width = 0, $height = 0, $color) {
    	if (!$this->info['width'] || !$this->info['height']) {
			return;
		}

		$xpos = 0;
		$ypos = 0;

		$scale = min($width / $this->info['width'], $height / $this->info['height']);
		
		if ($scale == 1) {
			return;
		}
		
		$new_width = (int)($this->info['width'] * $scale);
		$new_height = (int)($this->info['height'] * $scale);			
    	$xpos = (int)(($width - $new_width) / 2);
   		$ypos = (int)(($height - $new_height) / 2);
        		        
       	$image_old   = $this->image;
        @$this->image = imagecreatetruecolor($width, $height);
		
		//
		$arrColor = $this->html2rgb($color);
		
		
		@$background = imagecolorallocate($this->image, $arrColor[0], $arrColor[1], $arrColor[2]);
    	@imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
	
        @imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
        imagedestroy($image_old);
           
        $this->info['width']  = $width;
        $this->info['height'] = $height;
    }
	
	function autosizePNG( $width = 0, $height = 0, $file)
	{
		if ( $height <= 0 && $width <= 0 ) {
			return false;
		}
		
		if (!$this->info['width'] || !$this->info['height']) {
			return;
		}
		
		$xpos = 0;
		$ypos = 0;

		$scale = min($width / $this->info['width'], $height / $this->info['height']);
		if ($scale >= 1) {
			return;
		}
		
		$final_width = 0;
		$final_height = 0;
		
		$final_width = (int)($this->info['width'] * $scale);
		$final_height = (int)($this->info['height'] * $scale);			
    	$xpos = (int)(($width - $final_width) / 2);
   		$ypos = (int)(($height - $final_height) / 2);
			
		
		$image_old = $this->image;		
		$this->image = imagecreatetruecolor( $final_width, $final_height );
	
		if ( ($this->info['type'] == IMAGETYPE_GIF) || ($this->info['type'] == IMAGETYPE_PNG) ) {
		  $trnprt_indx = imagecolortransparent($image_old);
		
		  // Lay mau transaprent
		  if ($trnprt_indx >= 0) {
			$trnprt_color    = imagecolorsforindex($image_old, $trnprt_indx);
			$trnprt_indx    = imagecolorallocate($this->image , $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			imagefill($this->image , 0, 0, $trnprt_indx);
			//imagefilledrectangle($this->image, 0, 0, $width, $height, $trnprt_indx);
			imagecolortransparent($this->image , $trnprt_indx);
		  } 
		  elseif ($this->info['type'] == IMAGETYPE_PNG) {
			imagealphablending($this->image , false);
			$color = imagecolorallocatealpha($this->image , 0, 0, 0, 127);
			imagefill($this->image , 0, 0, $color);
			//imagefilledrectangle($this->image, 0, 0, $width, $height, $color);
			imagesavealpha($this->image , true);
		  }
		}
	
		imagecopyresampled($this->image , $image_old, 0, 0, 0, 0, $final_width, $final_height, $this->info['width'], $this->info['height']);
		imagedestroy($image_old);
		
		$this->info['width']  = $width;
        $this->info['height'] = $height;

		return true;
	}
	
	function resizePNG( $width = 0, $height = 0, $file)
	{
		if ( $height <= 0 && $width <= 0 ) {
			return false;
		}
		
		if (!$this->info['width'] || !$this->info['height']) {
			return;
		}
		
		$xpos = 0;
		$ypos = 0;
		if($width >0 && $height>0)
			$scale = min($width / $this->info['width'], $height / $this->info['height']);
		else
		{
			if($width>0)
				$scale = $width / $this->info['width'];
			if($height>0)
				$scale = $height / $this->info['height'];
		}
		if ($scale == 1) {
			return;
		}
		
		if ($scale > 1) {
			$scale = 1;
		}
		
		$final_width = 0;
		$final_height = 0;
		
		$final_width = (int)($this->info['width'] * $scale);
		$final_height = (int)($this->info['height'] * $scale);			
    	$xpos = (int)(($width - $final_width) / 2);
   		$ypos = (int)(($height - $final_height) / 2);
			
		
		$image_old = $this->image;		
		$this->image = imagecreatetruecolor( $final_width, $final_height );
	
		if ( ($this->info['type'] == IMAGETYPE_GIF) || ($this->info['type'] == IMAGETYPE_PNG) ) {
		  $trnprt_indx = imagecolortransparent($image_old);
		
		  // Lay mau transaprent
		  if ($trnprt_indx >= 0) {
			@$trnprt_color    = imagecolorsforindex($image_old, $trnprt_indx);
			$trnprt_indx    = imagecolorallocate($this->image , $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			imagefill($this->image , 0, 0, $trnprt_indx);
			//imagefilledrectangle($this->image, 0, 0, $width, $height, $trnprt_indx);
			imagecolortransparent($this->image , $trnprt_indx);
		  } 
		  elseif ($this->info['type'] == IMAGETYPE_PNG) {
			imagealphablending($this->image , false);
			$color = imagecolorallocatealpha($this->image , 0, 0, 0, 127);
			imagefill($this->image , 0, 0, $color);
			//imagefilledrectangle($this->image, 0, 0, $width, $height, $color);
			imagesavealpha($this->image , true);
		  }
		}
	
		imagecopyresampled($this->image , $image_old, 0, 0, 0, 0, $final_width, $final_height, $this->info['width'], $this->info['height']);
		imagedestroy($image_old);
		
		$this->info['width']  = $width;
        $this->info['height'] = $height;

		return true;
	}
	
	public function resize_white($width = 0, $height = 0) {
    	if (!$this->info['width'] || !$this->info['height']) {
			return;
		}

		$xpos = 0;
		$ypos = 0;

		$scale = min($width / $this->info['width'], $height / $this->info['height']);
		
		if ($scale == 1) {
			return;
		}
		
		$new_width = (int)($this->info['width'] * $scale);
		$new_height = (int)($this->info['height'] * $scale);			
    	$xpos = (int)(($width - $new_width) / 2);
   		$ypos = (int)(($height - $new_height) / 2);
        		        
       	$image_old   = $this->image;
        $this->image = imagecreatetruecolor($width, $height);
			
		$background = imagecolorallocate($this->image, 255, 255, 255);
    	imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
		
        imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
        imagedestroy($image_old);
           
        $this->info['width']  = $width;
        $this->info['height'] = $height;
    }
	
	function fixsize( $width = 0, $height = 0, $file)
	{
		if ( $height <= 0 && $width <= 0 ) {
			return false;
		}
		
		if (!$this->info['width'] || !$this->info['height']) {
			return;
		}
		
		$xpos = 0;
		$ypos = 0;

		$scale = max($width / $this->info['width'], $height / $this->info['height']);
	
		if ($scale == 1) {
			return;
		}
		
		$final_width = 0;
		$final_height = 0;
		
		$final_width = (int)($this->info['width'] * $scale);
		$final_height = (int)($this->info['height'] * $scale);			
    	$xpos = (int)(($width - $final_width) / 2);
   		$ypos = (int)(($height - $final_height) / 2);
			
		
		$image_old = $this->image;
				
		$this->image = imagecreatetruecolor( $width, $height );
	
		if ( ($this->info['type'] == IMAGETYPE_GIF) || ($this->info['type'] == IMAGETYPE_PNG) ) {
		  $trnprt_indx = imagecolortransparent($image_old);
		
		  // Lay mau transaprent
		  if ($trnprt_indx >= 0) {
			$trnprt_color    = imagecolorsforindex($image_old, $trnprt_indx);
			$trnprt_indx    = imagecolorallocate($this->image , $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			imagefill($this->image , 0, 0, $trnprt_indx);
			//imagefilledrectangle($this->image, 0, 0, $width, $height, $trnprt_indx);
			imagecolortransparent($this->image , $trnprt_indx);
		  } 
		  elseif ($this->info['type'] == IMAGETYPE_PNG) {
			imagealphablending($this->image , false);
			$color = imagecolorallocatealpha($this->image , 0, 0, 0, 127);
			imagefill($this->image , 0, 0, $color);
			//imagefilledrectangle($this->image, 0, 0, $width, $height, $color);
			imagesavealpha($this->image , true);
		  }
		}
	
		imagecopyresampled($this->image , $image_old, $xpos, $ypos, 0, 0, $final_width, $final_height, $this->info['width'], $this->info['height']);
		
		imagedestroy($image_old);
		
		$this->info['width']  = $width;
        $this->info['height'] = $height;

		return true;
	}
	
	function html2rgb($color)
	{
		if ($color[0] == '#')
			$color = substr($color, 1);
	
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
	
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	
		return array($r, $g, $b);
	}
	
	
}
?>