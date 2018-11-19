<?php
    class Photoupload 
    {
        private $tempName;       // Intial name reference
        public $imageFileType;   // The file type
        public $imageSize;       // The image size
        private $myTempImage;    // Initial image object
        private $myImage;        // Output image object
        public $fileName;        // Output file name
        private $uploadOk;       // Did the upload succeed
        public $errorsForUpload; // Otherwise what was the error

        function __construct($file) {
            //$this -> tempName = $file;
            $this -> tempName = $file["tmp_name"];
            $this -> imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            $this -> imageSize = $file["size"];
            $this -> imageFromFile();
            $this -> uploadOk = 1;
        }

        function __destruct() {
            // Kill image objects

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

        public function makeFileName($prefix = null){
            // Use a timestamp and predefined prefix as file name

            if ($prefix == null){
                $prefix = "vp_";
            }

            $timeStamp = microtime(1) * 10000;
            $this -> fileName = $prefix . $timeStamp . "." . $this -> imageFileType;
        }

        public function checkForImage(){
            // Check whether it is an image by asking for it's size

            $this -> errorsForUpload = "";
            $check = getimagesize($this->tempName);
            if($check == false) {
                $this -> errorsForUpload .= "Fail ei ole pilt.";
                $this -> uploadOk = 0;
            }
            return $this -> uploadOk;
        }

        public function checkForFileSize($size){
            // Check whether the file is small enough
            if ($this -> imageSize > $size) {
                $this -> errorsForUpload .= " Kahjuks on fail liiga suur!";
                $this -> uploadOk = 0;
            }
            return $this -> uploadOk;
        }

        public function checkForFileType(){
            // Check whether the file is one of the allowed filetypes
            if($this -> imageFileType != "jpg"
            && $this -> imageFileType != "png"
            && $this -> imageFileType != "jpeg"
            && $this -> imageFileType != "gif" ) {
                $this -> errorsForUpload .= " Kahjuks on lubatud vaid JPG, JPEG, PNG ja GIF failid!";
                $this -> uploadOk = 0;
            }
            return $this -> uploadOk;
        }

        public function checkIfExists($target){
            // Check whether the file already exists
            if (file_exists($target)) {
                $this -> errorsForUpload .= "Kahjuks on selline pilt juba olemas!";
                $this -> uploadOk = 0;
            }
            return $this -> uploadOk;
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

            // Keep transparency if the image has it
            imagesavealpha($newImage, true);
            $transColor = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefill($newImage, 0, 0, $transColor);

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