<?php

class Resize {
	
	private $image;
	private $width;
	private $height;
	private $imageResized;

	public function __construct($fileName) {
		global $firephp;
		$firephp->log('Resize - constructor');
		$firephp->log($fileName);
		// Open the file.
		$this->image = $this->openImage($fileName);
		$firephp->log('Resize - openImage');
		$firephp->log($this->image);
		// Get the width and height
		$this->width = imagesx($this->image);
		$firephp->log('Resize - width');
		$firephp->log($this->width);
		$this->height = imagesy($this->image);
	}

	private function openImage($file) {
		// Get extension
		$extension = strtolower(strrchr($file, '.'));
		switch($extension) {
			case '.jpg':
			case '.jpeg':
				$img = @imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = @imagecreatefromgif($file);
				break;
			case '.png':
				$img = false;
				break;
		}
		return $img;
	}

	public function resizeImage($newWidth, $newHeight, $option = "auto") {
		global $firephp;
		// Get optimal width and height - based on $option
		$optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));
		$firephp->log('Resize - optionArray');
		$firephp->log($optionArray);
		$optimalWidth = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];
		// Resample - create image canvas of x, y size.
		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
		// If option is 'crop', then crop too
		if ($option == 'crop') {
			$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
		}
	}

	private function getDimensions($newWidth, $newHeight, $option) {
		global $firephp;
		switch ($option) {
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight = $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight = $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight = $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
			case 'crop':
				$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		$firephp->log('Resize - getDimensions');
		$firephp->log(array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight));
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	// Step 9 - Basic dimensions
	// We’ve already discussed what these four methods do. They’re just basic maths, really, that calculate our best fit. 
	private function getSizeByFixedHeight($newHeight) {
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth) {
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

	private function getSizeByAuto($newWidth, $newHeight) {
		if ($this->height < $this->width) {
			// Image to be resized is wider (landscape)
			$optimalWidth = $newWidth;
			$optimalHeight = $this->getSizeByFixedWidth($newWidth);
		} elseif ($this->height > $this->width) {
			// Image to be resized is taller (portrait)
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight = $newHeight;
		} else {
			// Image to be resized is a square
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight = $this->getSizeByFixedWidth($newWidth);
			} else if ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight = $newHeight;
			} else {
				// Square being resized to a square
				$optimalWidth = $newWidth;
				$optimalHeight = $newHeight;
			}
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	private function getOptimalCrop($newWidth, $newHeight) {
		$heightRatio = $this->height / $newHeight;
		$widthRatio = $this->width / $newWidth;
		if ($heightRatio < $widthRatio) {
			$optimalRatio = $heightRatio;
		} else {
			$optimalRatio = $widthRatio;
		}
		$optimalHeight = $this->height / $optimalRatio;
		$optimalWidth = $this->width / $optimalRatio;
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	// Step 10 - Crop
	// This function supports the optional 'crop' argument.
	private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
		// Find center - this will be used for the crop
		$cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
		$cropStartY = ($optimalHeight / 2) - ($newHeight / 2);
		$crop = $this->imageResized;
		// imagedestroy($this->imageResized); why is this commented out...
		// Now crop from center to exact requested size
		$this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
	}

	public function saveImage($savePath, $imageQuality = "100") {
		// Get extension
		$extension = strrchr($savePath, '.');
		$extension = strtolower($extension);
		switch($extension) {
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG) {
					imagejpeg($this->imageResized, $savePath, $imageQuality);
				}
				break;
			case '.gif':
				if (imagetypes() & IMG_GIF) {
					imagegif($this->imageResized, $savePath);
				}
				break;
			case '.png':
				// Scale quality from 0-100 to 0-9
				$scaleQuality = round(($imageQuality / 100) * 9);
				// Invert quality setting as 0 is best, not 9
				$invertScaleQuality = 9 - $scaleQuality;
				if (imagetypes() & IMG_PNG) {
					imagepng($this->imageResized, $savePath, $invertScaleQuality);
				}
				break;
			// ... etc
			default:
				// No extension - no save.
				break;
		}
		imagedestroy($this->imageResized);
	}
}



