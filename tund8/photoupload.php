<?php
  require("functions.php");

	// If not signed in
	if(!isset($_SESSION["userId"])){
		header("Location: index_2.php"); // redirect user back
		exit();
	}
  
  	// When requesting signout
  	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: index_2.php");
		exit();
	}
	
	//Get profile details
	$profiledetails = getuserprofile($_SESSION["userId"]);
	//print_r($profiledetails);
	
	// Use profile values if they exist
	if ($profiledetails != null){
		if ($profiledetails[1] != null){
			$_SESSION["foregroundcolor"] = $profiledetails[1];
		}
		
		if ($profiledetails[2] != null){
			$_SESSION["backgroundcolor"] = $profiledetails[2];
		}
	}

	// Image submission https://www.w3schools.com/php/php_file_upload.asp
	$target_dir = "../vp_pic_uploads/";
	$uploadOk = 1;
	if(isset($_POST["submitImage"])) { // Check for image submission
		if(!empty($_FILES["fileToUpload"]["tmp_name"])) {
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			$timeStamp = microtime(1) * 10000; // multiply to make it an int
			$target_file = $target_dir . "vp_" . $timeStamp . "." . $imageFileType;
			
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
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laaditud.";
				} else {
					echo "Vabandust, faili üleslaadimisel esines tehniline viga.";
				}
			}
		}
	}

	$pageTitle = "Fotode üleslaadimine";
	require("header.php");
?>

	<hr><p>Olete sisseloginud nimega: <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>.</p> 
	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="main.php">Tagasi</a></li>
	</ul>

		
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
		<label for="fileToUpload">Vali üleslaaditav pilt:</label><br/>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Laadi pilt üles" name="submitImage">
	</form>

	<?php require("footer.php"); ?>
