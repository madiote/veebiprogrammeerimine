<?php
	require("functions.php");
	require("header-account.php");

	// Set profile details on submit
	if (isset($_POST["setUserProfile"])){
		$description = test_input($_POST["description"]);
		setuserprofile($_SESSION["userId"], $description, $_POST["foreground"], $_POST["background"]); // Image sent by uploadProfilePic
		$profilepic = uploadProfilePic($_POST["profilePicUpload"]); // TODO: Does not return anything?

		// Show sent data on the page
		if (isset($_POST["profilePicUpload"])){
			$profilepic = $profilepicpath . $profilepic; // $profilepicpath courtesy of header-account.php
			$_SESSION["profilePic"] = $profilepic;
		}
		else {
			$profilepic = $profilepicpath . $noprofilepic;
		}

		if (isset($_POST["description"])){
			$descriptiontext = $_POST["description"];
			//$_SESSION["description"] = $descriptiontext;
			//Uncomment if you need the description text in session
		}
		else {
			$descriptiontext = "Pole iseloomustust lisanud.";
		}
		
		if (isset($_POST["foreground"])){
			$foregroundcolor = $_POST["foreground"];
			$_SESSION["foregroundcolor"] = $foregroundcolor;
		}
		else {
			$foregroundcolor = "#000000";
		}

		if (isset($_POST["background"])){
			$backgroundcolor = $_POST["background"];
			$_SESSION["backgroundcolor"] = $backgroundcolor;
		}
		else {
			$backgroundcolor = "#ffffff";
		}	

	}
	$pageTitle = "Profiiliteave";
	require("header.php");
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/formdata">
	<label>Nimi:</label>
	<input type="text" value="<?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>" disabled><br>
	<label>Foto:</label><br>
	<img src="<?php echo $profilepic; ?>" alt="<?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>">
	<br>
	<input type="file" name="profilePicUpload"><br>
	<label>Kirjeldus (max 300 märki):</label>
	<br>
	<textarea name="description" rows="4" cols="64" maxlength="300"><?php echo $descriptiontext; ?></textarea>
	<br>
	<label>Teksti värv:</label>
	<input type="color" name="foreground" value="<?php echo $foregroundcolor; ?>">
	<br>
	<label>Tausta värv:</label>
	<input type="color" name="background" value="<?php echo $backgroundcolor; ?>">
	<br>
	<input type="submit" name="setUserProfile" value="Salvesta profiil">
</form>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
