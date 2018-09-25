<?php
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
	$fullName = "";
	$monthToday = date("m");
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$amountOfMonths = count($monthNamesET);

	// Assign the variable values with POST, sanitize
	if(isset($_POST["firstname"])){
		$firstName = test_input($_POST["firstname"]);
	}
	
	if(isset($_POST["lastname"])){
		$lastName = test_input($_POST["lastname"]);
	}
	
	if(isset($_POST["birthyear"])){
		$birthYear = test_input($_POST["birthyear"]);
	}
	
	function test_input($data) { // Sanitize input
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	function stupidFunction() {
		$GLOBALS["fullName"] = $GLOBALS["firstName"] . " " . $GLOBALS["lastName"];
	}
	
	stupidFunction();
?>
<!DOCTYPE html>

<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>
			<?php
				echo $firstName;
				echo " ";
				echo $lastName;
			?>, õppetöö
		</title>
		<link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
	</head>

	<body>
		<h1>
			<?php
				echo $firstName . " " . $lastName;
			?>
		</h1>
		
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Eesnimi</label>
			<input type="text" name="firstname">
			<br />
			<label>Perekonnanimi</label>
			<input type="text" name="lastname">
			<br />
			<label>Sünniaasta</label>
			<input type="number" min="1914" max="2000" value="2000" name="birthyear">
			<br />
			<select name="birthMonth">
			<?php

				for ($i = 1; $i <= $amountOfMonths; $i++){
					if($i == $monthToday){
						echo '<option value="'. $i . '" selected>' . $monthNamesET[$i - 1] . '</option>' . "\n";
					} else {
						echo '<option value="'. $i . '">' . $monthNamesET[$i - 1] . '</option>' . "\n";
					}
				}
			?>
			</select>
			<input type="submit" name="submitUserData" value="Saada andmed">
		</form>
		
		<?php
		if(isset($_POST["birthyear"])){
			echo "<h2>" . $fullName . "</h2>";
			echo "<p>Oled elanud nendel aastatel: </p> \n";
			echo "<ol>\n";
				for ($i = $_POST["birthyear"]; $i <= date("Y"); $i++){
					echo "<li>". $i ."</li>\n";
				}	
			echo "</ol>\n";
		}
		?>
		
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
