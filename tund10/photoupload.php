<?php
	require("functions.php");
	require("header-account.php");

	require("classes/Photoupload.class.php");

	/*
	require("classes/Test.class.php");
	$myNumber = new Test(7);
	echo "Avalik arv on: " . $myNumber -> publicNumber; // 28
	//echo "Salajane arv on: " . $myNumber -> secretNumber; // veateade
	$myNumber -> tellThings(); // käivita klass
	$mySNumber = new Test(9);
	echo "Teine avalik arv on: " . $mySNumber -> publicNumber; // 28
	unset($myNumber); // lõpeta klassi täitmine ära, käita __destruct
	*/

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
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto -> changePhotoSize(600, 400);
				$myPhoto -> addWatermark();
				$myPhoto -> addText();
				$savesuccess = $myPhoto -> saveFile($target_file);
				unset($myPhoto);

				// If upload succeeded
				if ($savesuccess == 1){
					addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
					echo "Pilt üles laaditud!";
				}
				else {
					echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
				}

				/* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laaditud.";
				} else {
					echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
				} */
			}
		}
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
