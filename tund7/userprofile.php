<?php
	require("functions.php");
	
	// If not signed in
	if(!isset($_SESSION["userId"])){
		header("Location: index_2.php"); // redirect user back
		exit();
	}

	
	//Get profile details
	$profiledetails = getuserprofile($_SESSION["userId"]);
	//print_r($profiledetails);
	
	// Use profile values if they exist
	if ($profiledetails != null){
		if ($profiledetails[0] != null){
			$descriptiontext = $profiledetails[0];
			// Session variable not needed
		}
		
		if ($profiledetails[1] != null){
			$foregroundcolor = $profiledetails[1];
			$_SESSION["foregroundcolor"] = $foregroundcolor;
		}
		
		if ($profiledetails[2] != null){
			$backgroundcolor = $profiledetails[2];
			$_SESSION["backgroundcolor"] = $backgroundcolor;
		}
	}
	
	// Set profile details on submit
	if (isset($_POST["setUserProfile"])){
		$description = test_input($_POST["description"]);
		setuserprofile($_SESSION["userId"], $description, $_POST["foreground"], $_POST["background"]);
		
		// Show sent data on the page
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
?>
<!DOCTYPE html>

<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>Anonüümse sõnumi lisamine</title>
		<link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
		<style>
			body {
				background-color: <?php echo $_SESSION["backgroundcolor"]; ?>;
				color: <?php echo $_SESSION["foregroundcolor"]; ?>
			} 
		</style>
	</head>

	<body>
		<h1>Kasutajaprofiil</h1>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Kirjeldus (max 300 märki):</label>
			<br>
			<textarea name="description" rows="4" cols="64" maxlength="300"><?php echo $descriptiontext; ?></textarea>
			<br>
			<label>Teksti värv:</label>
			<input type="color" name="foreground" value="<?php echo $foregroundcolor; ?>">
			<br>
			<label>Tausta värv:</label>
			<input type="color" name="background" value="<?php echo $backgroundcolor; ?>">
			</br>
			<input type="submit" name="setUserProfile" value="Salvesta profiil">
		</form>
		<ul>
			<li><a href="main.php?logout=1">Logi välja</a></li>
			<li><a href="main.php">Tagasi</a></li>
		</ul>
		
		<hr />
		<iframe src="../footer.html" frameBorder="0" height="auto" width="100%"></iframe>
		<script src="../../force-https.js"></script> <!-- Force HTTPS with javascript -->
	</body>
</html>
