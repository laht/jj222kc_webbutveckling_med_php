<?php

namespace posts\model;

//class to save images to the server
class ImageModel {

	const maxWidth = 500;
	const maxHeight = 500;

	public $imageName;
	public $imagePath = "images/";
	private $uploadedImage;
	private $imageFormat;
	private $temporaryName;

	//takes an uploaded file from the client
	//sets member variables with the file data
	public function __construct($image) {
		$this->uploadedImage = $image;
		$this->imageName = $image['name'];
		$this->temporaryName = $image['tmp_name'];
		$this->imageFormat = $this->uploadedImage['type'];

	}
	
	//if image is not a valid format throw exception
	//if image size is not within the accepted boundries, resize and then save it
	public function processImage() {
		//determine the fileformat
		switch ($this->imageFormat) {
			case 'image/jpeg':
				$src = imagecreatefromjpeg($this->temporaryName);
				break;
			case 'image/jpg':
				$src = imagecreatefromjpeg($this->temporaryName);
				break;
			case 'image/gif':
				$src = imagecreatefromgif($this->temporaryName);
				break;
			case 'image/png':
				$src = imagecreatefrompng($this->temporaryName);
				break;
			//if fileformat isn't any of the accepted formats throw exception
			default:
				throw new \Exception("Invalid file format");
				break;		
		}
		//get the original width and height of the image
		list($width, $height) = getimagesize($this->temporaryName);
		if ($width > self::maxWidth) {
			$this->scaleWidth($src, $width, $height);
		}
		else if ($height > self::maxHeight) {
			$this->scaleHeight($src, $width, $height);
		}
		else {			
			move_uploaded_file($this->temporaryName, $this->imagePath.$this->imageName());			
		}
	}

	//set the rights on the uploads folder 
	//and then upload the image and reset the rights
	//and the login information should not be stored in git
	public function saveImage() {
		$ftp_server = "eu5.org";
		$ftp_conn = ftp_connect($ftp_server) or die("couldn't connect");
		$login = ftp_login($ftp_conn, "laht.eu5.org", "sonickkk123");
		$file = "images";
		//0777 for full rights to read and write
		ftp_chmod($ftp_conn, 0777, $file);
		$this->processImage();
		//0755 for rights to read and execute
		//if execute is disabled images will not be loaded
		ftp_chmod($ftp_conn, 0755, $file);
		ftp_close($ftp_conn);
	}

	//From http://stackoverflow.com/questions/5349173/create-unique-image-names
	//give the image a unique name
	private function imageName() {
		$format = pathinfo($this->imageName, PATHINFO_EXTENSION);
		$uniqueName = substr(base_convert(time(), 10, 36).md5(microtime()), 0, 16).".".$format;
		$this->imageName = $uniqueName;
		return $uniqueName;
	}

	//Resize with new width and adjust the height to keep ratio and then save the image
	private function scaleWidth($src, $width, $height) {
		//ratio of image
		$ratio = $width/$height;
		//new width to keep aspect ratio
		$newHeight = self::maxWidth / $ratio;
		//create a temporary image
		$newImage = imagecreatetruecolor(self::maxWidth, $newHeight);	
		//copy the original image and resample it with new width height
		imagecopyresampled($newImage, $src, 0, 0, 0, 0,
		 				   self::maxWidth, $newHeight, $width, $height);
		//save the resampled image
		imagejpeg($newImage, $this->imagePath.$this->imageName(), 100);
		//remove resources from memory		
		imagedestroy($src);
		imagedestroy($newImage);
	}
	
	//Resize with new height and adjust the width to keep ratio and then save the image
	private function scaleHeight($src, $width, $height) {
		//ratio of image
		$ratio = $width/$height;
		//new width to keep aspect ratio
		$newWidth = self::maxHeight * ratio;
		//create a temporary image
		$newImage = imagecreatetruecolor($newWidth, self::maxHeight);	
		//copy the original image and resample it with new width height
		imagecopyresampled($newImage, $src, 0, 0, 0, 0,
		 				   $newWidth, self::maxHeight, $width, $height);
		//save the resampled image
		imagejpeg($newImage, $this->imagePath.$this->imageName(), 100);
		//remove resources from memory
		imagedestroy($src);
		imagedestroy($newImage);
		move_uploaded_file($this->temporaryName, $this->imagePath.$this->imageName());
	}

	//Validate format of uploaded file.
	public function validateImage() {
		//valid image formats
		$validFormats = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', "image/JPEG", "image/JPG");
		//if there is no file throw exception		
		if ($this->imageFormat == "") {
			throw new \Exception("The selected file is not in a valid format");
		}
		//if image is not in valid format throw exception
		else if (!in_array($this->imageFormat, $validFormats)) {
			throw new \Exception("The selected file is not in a valid format");
		}
	}
}