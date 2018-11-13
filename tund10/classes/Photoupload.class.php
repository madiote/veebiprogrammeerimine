<?php
    class Photoupload 
    {
        private $myTempImage;
        private $imageFileType; 
        private $tempName;
        private $myImage;

        public function __construct($file, $type) {
            $this -> tempName = $file;
            $this -> imageFileType = $type;
            $this -> imageFromFile();
        }

        public function __destruct() {
            imagedestroy($this -> myTempImage);
            imagedestroy($this -> myImage);
        }

        private function imageFromFile(){
            // Create an image object according to filetype

            if ($this -> imageFileType == "jpg" or $this -> imageFileType == "jpeg"){
                $this -> myTempImage = imagecreatefromjpeg($this -> tempName);
            }
            else if ($this -> imageFileType == "png"){
                $this -> myTempImage = imagecreatefrompng($this -> tempName);
            }
            else if ($this -> imageFileType == "gif"){
                $this -> myTempImage = imagecreatefromgif($this -> tempName);
            }
        }

        public function changePhotoSize($width, $height){
            // Start resizing the photo with proper ratio

            $imageWidth = imagesx($this -> myTempImage);
            $imageHeight = imagesy($this -> myTempImage);
            
            // Calculate size ratio
            if ($imageWidth > $imageHeight){
                $sizeRatio = $imageWidth / $width;
            }
            else {
                $sizeRatio = $imageHeight / $height;
            }

            $newWidth = round($imageWidth / $sizeRatio);
            $newHeight = round($imageHeight / $sizeRatio);

            $this -> myImage = $this -> resizeImage($this -> myTempImage, 
                                                    $imageWidth, $imageHeight, $newWidth, $newHeight);
        }

        private function resizeImage($image, $ow, $oh, $w, $h){
            // Resize the photo physically (exact values given by changePhotoSize)

            $newImage = imagecreatetruecolor($w, $h);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
    
            return $newImage;
        }

        public function addWatermark(){
            // Append watermark (image) to the photo

            $waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png"); // relative to the php file that runs the class
            $waterMarkWidth = imagesx($waterMark);
            $waterMarkHeight = imagesy($waterMark);
            $waterMarkPosX = imagesx($this -> myImage) - $waterMarkWidth - 10; // 10 px as padding
            $waterMarkPosY = imagesy($this -> myImage) - $waterMarkHeight - 10; // 10 px as padding

            imagecopy($this -> myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
        }

        public function addText(){
            // Append (watermark) text to the photo

            $textToImage = "Veebiprogrammeerimine";
            $textColor = imagecolorallocatealpha($this -> myImage, 255, 255, 255, 60);
            imagettftext($this -> myImage, 20, 0, 10, 30, $textColor, "../vp_picfiles/Roboto-Bold.ttf", $textToImage);
        }

        public function saveFile($target_file){
            // Save file back according to original filetype
            $notice = null;

            if ($this -> imageFileType == "jpg" or $this -> imageFileType == "jpeg"){
                if(imagejpeg($this -> myImage, $target_file, 95)){
                    $notice = 1;
                }
                else {
                    $notice = 0;
                }
            }
            else if ($this -> imageFileType == "png"){
                if(imagepng($this -> myImage, $target_file, 95)){
                    $notice = 1;
                }
                else {
                    $notice = 0;
                }
            }
            else if ($this -> imageFileType == "gif"){
                if(imagegif($this -> myImage, $target_file, 95)){
                    $notice = 1;
                }
                else {
                    $notice = 0;
                }
            }

            return $notice;
        }
    }
?>