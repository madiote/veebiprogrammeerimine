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

	$notice = "";
	$thumb_size = 100;
    $target_dir = $picDir; // from config.php
    $thumb_dir = $thumbDir; // from config.php
    $uploadOk = 1; // assume upload is ok, unless told otherwise

	if(isset($_POST["submitImage"])) { // Check for image submission - https://www.w3schools.com/php/php_file_upload.asp
		if(!empty($_FILES["fileToUpload"]["name"])) {

            $myPhoto = new Photoupload($_FILES["fileToUpload"]);

            // Set the file name
            $myPhoto -> makeFileName();
            $target_file = $target_dir . $myPhoto -> fileName;

            // Check whether it is a suitable image
            $uploadOk = $myPhoto->checkForImage();
            if($uploadOk == 1){
                // Check for type
                $uploadOk = $myPhoto->checkForFileType();
            }

            if($uploadOk == 1){
                // Check for size
                $uploadOk = $myPhoto->checkForFileSize($_FILES["fileToUpload"], 2500000);
            }

            if($uploadOk == 1){
                // Check if exists
                $uploadOk = $myPhoto->checkIfExists($target_file);
            }

            // Otherwise, if there is an error
            if ($uploadOk == 0) {
                $notice = "Vabandame, faili ei laetud üles! Tekkisid vead: " . $myPhoto -> errorsForUpload;
                // If everything is correct, upload
            } else {

                $myPhoto -> changePhotoSize(600, 400);

                $exif = $myPhoto -> readExif();
                if ($exif != null){
                    $myPhoto -> addText($exif);
                }
                else {
                    $myPhoto -> addText();
                }

                $myPhoto -> addWatermark();
                $savesuccess = $myPhoto -> saveFile($target_file);

                // If upload succeeded, save to database
                if ($savesuccess == 1){
                    $myPhoto -> createThumbnail($thumb_dir, $thumb_size);
                    $notice = "Pilt üles laaditud!";
                    addPhotoData($myPhoto -> fileName, $_POST["altText"], $_POST["privacy"]);
                }
                else {
                    $notice = "Foto lisamisel andmebaasi tekkis viga!";
                }
            }
            unset($myPhoto);

            /* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laaditud.";
            } else {
                $notice = "Vabandust, faili üleslaadimisel esines tehniline viga.";
            } */
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
	<input type="submit" value="Laadi pilt üles" name="submitImage"><br/>
    <b><?php echo $notice; ?></b>
</form>

<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
