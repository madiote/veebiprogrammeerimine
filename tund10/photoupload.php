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
	// Image submission https://www.w3schools.com/php/php_file_upload.asp
	if(isset($_POST["submitImage"])) { // Check for image submission
		if(!empty($_FILES["fileToUpload"]["tmp_name"])) {
			$timeStamp = microtime(1) * 10000; // multiply to make it an int
			$target_dir = "../vp_pic_uploads/";
			$target_file_name = "vp_" . $timeStamp;
			$target_file = $target_dir . $target_file_name;

            $myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"]);
            echo "Faili tüüp on " . $myPhoto -> getFileType(); // TODO: Why is it empty?
            $uploadsuccess = $myPhoto -> suitableImage();

            if ($uploadsuccess == 0){

                $target_file_name .= "." . $myPhoto -> getFileType(); // append filetype to target file name
                $target_file = $target_dir . $target_file_name; // overwrite target_file again

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
            }
            else if ($uploadsuccess == 1){
                $notice = "Tegu ei ole sobiva JPG, PNG või GIF-pildiga.";
            }
            else if ($uploadsuccess == 2){
                $notice = "Pilt on juba olemas.";
            }
            else if ($uploadsuccess == 3){
                $notice = "Antud pilt on liiga suur.";
            }

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
	<input type="submit" value="Laadi pilt üles" name="submitImage">
    <b><?php echo $notice; ?></b>
</form>

<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
