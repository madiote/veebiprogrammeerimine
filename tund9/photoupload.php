<?php
	require("functions.php");
	require("header-account.php");

	// Image submission https://www.w3schools.com/php/php_file_upload.asp
	$target_dir = "../vp_pic_uploads/";
	$uploadOk = 1;
	if(isset($_POST["submitImage"])) { // Check for image submission
		if(!empty($_FILES["fileToUpload"]["tmp_name"])) {
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			$timeStamp = microtime(1) * 10000; // multiply to make it an int
			//$target_file = $target_dir . "vp_" . $timeStamp . "." . $imageFileType;
			
			$target_file_name = "vp_" . $timeStamp . "." . $imageFileType;
			$target_file = $target_dir . $target_file_name;

			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				//echo "Fail on " . $check["mime"] . " pilt.";
				$uploadOk = 1;
			} else {
				echo "Fail ei ole pilt.";
				$uploadOk = 0;
			}
			
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Vabandust, see pilt on juba olemas.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 2500000) {
				echo "Vabandust, see pilt on liiga suur.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Vabandust, siia saab üles laadida vaid JPG, JPEG, PNG ja GIF faile.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Vabandust, seda faili ei saanud üles laadida.";
			// if everything is ok, try to upload file
			} else {
				// Loome vastavalt failitüübile pildiobjekti

				if ($imageFileType == "jpg" or $imageFileType == "jpeg"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				else if ($imageFileType == "png"){
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				else if ($imageFileType == "gif"){
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}

				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				// Arvuta suuruse suhtarv
				if ($imageWidth > $imageHeight){
					$sizeRatio = $imageWidth / 600;
				}
				else {
					$sizeRatio = $imageHeight / 400;
				}

				$newWidth = round($imageWidth / $sizeRatio);
				$newHeight = round($imageHeight / $sizeRatio);

				$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);

				// Add watermark image

				$waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
				$waterMarkWidth = imagesx($waterMark);
				$waterMarkHeight = imagesy($waterMark);
				$waterMarkPosX = $newWidth - $waterMarkWidth - 10; // 10 px as padding
				$waterMarkPosY = $newHeight - $waterMarkHeight - 10;

				imagecopy($myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);

				// Add watermark text
				$textToImage = "Veebiprogrammeerimine";
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 60);
				imagettftext($myImage, 20, 0, 10, 30, $textColor, "../vp_picfiles/Roboto-Bold.ttf", $textToImage);

				// Save file back according to original filetype
				if ($imageFileType == "jpg" or $imageFileType == "jpeg"){
					if(imagejpeg($myImage, $target_file, 95)){
						echo "Fail ". basename( $_FILES["fileToUpload"]["name"]) . " on üles laaditud.";
						addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
					}
					else {
						echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
					}
				}
				else if ($imageFileType == "png"){
					if(imagepng($myImage, $target_file, 95)){
						echo "Fail ". basename( $_FILES["fileToUpload"]["name"]) . " on üles laaditud.";
						addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
					}
					else {
						echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
					}
				}
				else if ($imageFileType == "gif"){
					if(imagegif($myImage, $target_file, 95)){
						echo "Fail ". basename( $_FILES["fileToUpload"]["name"]) . " on üles laaditud.";
						addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
					}
					else {
						echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
					}
				}

				imagedestroy($myTempImage);
				imagedestroy($myImage);

				/* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laaditud.";
				} else {
					echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
				} */
			}
		}
	}

	function resizeImage($image, $ow, $oh, $w, $h){
		$newImage = imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);

		return $newImage;
	}

	$pageTitle = "Fotode üleslaadimine";
	require("header.php");
?>		
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<label for="fileToUpload">Vali üleslaaditav pilt:</label><br/>
	<input type="file" name="fileToUpload" id="fileToUpload"><br/>
	<label>Pildi kirjeldus (max 256. tähemärki)</label><br/>
	<input type="text" name="altText"><br/>
	<label>Pildi kasutusõigused</label><br/>
	<input type="radio" name="privacy" value="1"><label>Avalik</label>
	<input type="radio" name="privacy" value="2"><label>Sisseloginud kasutajatele</label>
	<input type="radio" name="privacy" value="3" checked><label>Privaatne</label><br/>
	<input type="submit" value="Laadi pilt üles" name="submitImage">
</form>

<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
