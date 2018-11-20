<?php
	require("functions.php");
	require("header-account.php");

    require("classes/Photoupload.class.php");

    $notice = "";
    $imgnotice = "";


    $mydescription = "Pole tutvustust lisanud!";
    $mybgcolor = "#FFFFFF";
    $mytxtcolor = "#000000";
    $profilePic = "../vp_picfiles/vp_user_generic.png"; // Placeholder image

    // Photo upload
    $target_dir = "../vpuser_picfiles/";
    $addedPhotoId = null;

    $target_file = "";
    $uploadOk = 1;
    $imageFileType = "";

    // Set profile details on submit
	if (isset($_POST["setUserProfile"])){

        // Show sent data on the page
        if(!empty($_POST["description"])){
            $mydescription = $_POST["description"];
        }
        $mybgcolor = $_POST["bgcolor"];
        $mytxtcolor = $_POST["txtcolor"];

        // Profile picture upload
        if(!empty($_FILES["profilePicUpload"]["name"])) {

            $myPhoto = new Photoupload($_FILES["profilePicUpload"]);

            // Set the file name
            $myPhoto -> makeFileName("vpuser_");
            $target_file = $target_dir . $myPhoto -> fileName;

            // Check whether it is a suitable image
            $uploadOk = $myPhoto->checkForImage();
            if($uploadOk == 1){
                // Check for type
                $uploadOk = $myPhoto->checkForFileType();
            }

            if($uploadOk == 1){
                // Check for size
                $uploadOk = $myPhoto->checkForFileSize($_FILES["profilePicUpload"], 2500000);
            }

            if($uploadOk == 1){
                // Check if exists
                $uploadOk = $myPhoto->checkIfExists($target_file);
            }

            // Otherwise, if there is an error
            if ($uploadOk == 0) {
                $imgnotice = "Vabandame, faili ei laetud üles! Tekkisid vead: " . $myPhoto -> errorsForUpload;
                // If everything is correct, upload
            } else {

                $myPhoto -> profilePicSize(300);
                $myPhoto -> addWatermark();
                $savesuccess = $myPhoto -> saveFile($target_file);

                // If upload succeeded, save to database
                if ($savesuccess == 1){
                    $imgnotice = "Pilt üles laaditud!";
                    addUserPhotoData($myPhoto -> fileName);
                }
                else {
                    $imgnotice = "Foto lisamisel andmebaasi tekkis viga!";
                }
            }
            unset($myPhoto);

            /* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laaditud.";
            } else {
                $notice = "Vabandust, faili üleslaadimisel esines tehniline viga.";
            } */
        } else {
            $profilePic = $_POST["profilepic"];
        }
        // Save the user profile
        $notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"], $addedPhotoId);

    } else {
        $myprofile = showmyprofile();
        if($myprofile -> description != ""){
            $mydescription = $myprofile -> description;
        }
        if($myprofile -> bgcolor != ""){
            $mybgcolor = $myprofile -> bgcolor;
        }
        if($myprofile -> txtcolor != ""){
            $mytxtcolor = $myprofile -> txtcolor;
        }
        if($myprofile -> picture != ""){
            $profilePic = $profilePicDirectory . $myprofile -> picture;
        }
    }
	$pageTitle = "Profiiliteave";
	require("header.php");
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	<label>Nimi:</label>
	<input type="text" value="<?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>" disabled><br>
	<label>Foto:</label><br>
	<img src="<?php echo $profilePic; ?>" alt="<?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>"><br>
    <input type="hidden" name="profilepic" value="<?php echo $profilePic; ?>">
    <b><?php echo $imgnotice; ?></b>
    <br>
	<input type="file" name="profilePicUpload"><br>
	<label>Kirjeldus (max 300 märki):</label>
	<br>
	<textarea name="description" rows="4" cols="64" maxlength="300"><?php echo $mydescription; ?></textarea>
	<br>
	<label>Teksti värv:</label>
	<input type="color" name="txtcolor" value="<?php echo $mytxtcolor; ?>">
	<br>
	<label>Tausta värv:</label>
	<input type="color" name="bgcolor" value="<?php echo $mybgcolor; ?>">
	<br>
    <input type="submit" name="setUserProfile" value="Salvesta profiil"><br>
    <b><?php echo $notice; ?></b>
</form>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
