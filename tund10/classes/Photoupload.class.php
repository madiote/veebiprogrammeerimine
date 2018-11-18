<?php
    class Photoupload 
    {
        private $tempName;      // Intial name reference
        private $imageFileType; // The file type
        private $myTempImage;   // Initial image object
        private $myImage;       // Output image object

        public function __construct($file) {
            $this -> tempName = $file;
            $this -> getFileType();
            $this -> suitableImage();
            $this -> imageFromFile();
        }

        public function __destruct() {
            // Kill image objects

            if($this -> myTempImage != null){
                imagedestroy($this -> myTempImage);
            }

            if($this -> myImage != null) {
                imagedestroy($this->myImage);
            }
        }

        public function getFileType(){
            // Assume the file type by file extension

            $this -> imageFileType = strtolower(pathinfo(basename($this -> tempName),PATHINFO_EXTENSION));

            return $this -> imageFileType;
        }

        public function suitableImage(){
            // Check if the image is suitable for upload

            $notice = 0;
            $check = getimagesize($this -> tempName);

            if ($this -> imageFileType != "jpg" // Check if it claims to be an image
                && $this -> imageFileType != "jpeg"
                && $this -> imageFileType != "png"
                && $this -> imageFileType != "gif" ) {
                $notice = 1;
            }
            else if($check !== false) { // Check if it is sized like an image
                $notice = 1;
            }
            else if (file_exists($this -> tempName)) { // Check if file already exists
                $notice = 2;
            }
            else if ($this -> tempName > 2500000) {  // Check file size
                $notice = 3;
            }

            return $notice;
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

        public function addWatermark($wmPath = null){
            // Append watermark (image) to the photo
            if ($wmPath == null){
                $waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png"); // relative to the php file that runs the class
            }
            else {
                $waterMark = imagecreatefrompng($wmPath); // relative to the php file that runs the class
            }
            $waterMarkWidth = imagesx($waterMark);
            $waterMarkHeight = imagesy($waterMark);
            $waterMarkPosX = imagesx($this -> myImage) - $waterMarkWidth - 10; // 10 px as padding
            $waterMarkPosY = imagesy($this -> myImage) - $waterMarkHeight - 10; // 10 px as padding

            imagecopy($this -> myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
        }

        public function addText($text = null){
            // Append (watermark) text to the photo

            if ($text == null){
                $textToImage = "Veebiprogrammeerimine";
            }
            else {
                $textToImage = $text;
            }
            $textColor = imagecolorallocatealpha($this -> myImage, 255, 255, 255, 60);
            imagettftext($this -> myImage, 20, 0, 10, 30, $textColor, "../vp_picfiles/Roboto-Bold.ttf", $textToImage);
        }

        public function saveFile($target_file){
            // Save file back according to original filetype
            $notice = 0;

            if ($this -> imageFileType == "jpg" or $this -> imageFileType == "jpeg"){
                if(imagejpeg($this -> myImage, $target_file, 95)){
                    $notice = 1;
                }
            }
            else if ($this -> imageFileType == "png"){
                if(imagepng($this -> myImage, $target_file, 95)){
                    $notice = 1;
                }
            }
            else if ($this -> imageFileType == "gif"){
                if(imagegif($this -> myImage, $target_file)){
                    $notice = 1;
                }
            }

            return $notice;
        }
    }
?>