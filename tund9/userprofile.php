<?php
	require("functions.php");
	require("header-account.php");

	// Set profile details on submit
	if (isset($_POST["setUserProfile"])){
		$description = test_input($_POST["description"]);
		setuserprofile($_SESSION["userId"], $description, $_POST["foreground"], $_POST["background"]);
		
		// Show sent data on the page
		if (isset($_POST["profilePicUpload"])){
			uploadProfilePic($_POST["profilePicUpload"]);
		}
		else {
			// Keep the old profile pic
		}

		if (isset($_POST["description"])){
			$descriptiontext = $_POST["description"];
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

	$pageTitle = "Anonüümne sõnum";
	require("header.php");
?>

		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Foto:</label><br>
			<img src="<?php echo $profilepic; ?>" alt="<?php echo $_SESSION["userId"]; ?>">
			<br>
			<input type="file" id="profilePicUpload"><br/>
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
		<ul>
			<li><a href="main.php?logout=1">Logi välja</a></li>
			<li><a href="main.php">Tagasi</a></li>
		</ul>
		
		<?php require("footer.php"); ?>
