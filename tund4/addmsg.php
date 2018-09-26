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
?>
<!DOCTYPE html>

<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>Anonüümse sõnumi lisamine</title>
		<link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
	</head>

	<body>
		<h1>Sõnumi lisamine</h1>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Sõnum (max 256 märki):</label>
			<br>
			<textarea name="message" rows="4" cols="64" maxlength="256">Sõnum</textarea>
			<br>
			<input type="submit" name="submitMessage" value="Salvesta sõnum">
		</form>
		<p><?php echo $notice; ?></p>
		
		
		<hr />
		<div class="links"> <!-- Autogenerate list of links in current folder -->
			<p>Selle tunni lehed:
				<?php
					$dirFiles = scandir("./");
					for ($i = 2; $i < count($dirFiles); $i++){
						echo '<a href="./' . $dirFiles[$i] . '">' . $dirFiles[$i]. '</a> ';
					}
				?>
			</p>
		</div>
		<iframe src="../footer.html" frameBorder="0" height="auto" width="100%"></iframe>
		<script src="../force-https.js"></script> <!-- Force HTTPS with javascript -->
	</body>
</html>
