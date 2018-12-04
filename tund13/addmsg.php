<?php
	require("functions.php");
	$notice = null;
	
	if (isset($_POST["submitMessage"])){
		if ($_POST["message"] != "Sõnum" and !empty($_POST["message"])){ // Check for placeholder or empty
			$message = test_input($_POST["message"]);
			$notice = saveamsg($message);
		}
		else {
			$notice = "Palun kirjuta sõnum.";
		}
	}
	
	$pageTitle = "Sõnumid";
	require("header.php");
?>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Sõnum (max 256 märki):</label>
			<br>
			<textarea name="message" rows="4" cols="64" maxlength="256">Sõnum</textarea>
			<br>
			<input type="submit" name="submitMessage" value="Salvesta sõnum">
		</form>
		<p><?php echo $notice; ?></p>
		<a href="index_2.php">Tagasi</a>
		
		<?php require("footer.php"); ?>
