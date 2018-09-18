<?php
	//echo "See on minu esimene PHP!";
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
	
	//Määra muutujate väärtused POST-requesti järgi
	if(isset($_POST["firstname"])){
		$firstName = $_POST["firstname"];
	}
	
	if(isset($_POST["lastname"])){
		$lastName = $_POST["lastname"];
	}
	
	if(isset($_POST["birthyear"])){
		$birthYear = $_POST["birthyear"];
	}
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
		<p>Tere tulemast page.php lehele! <a href="../tund3">Tagasi tund3 indeksile</a></p>
		<form method="POST">
			<label>Eesnimi</label>
			<input type="text" name="firstname">
			<br />
			<label>Perekonnanimi</label>
			<input type="text" name="lastname">
			<br />
			<label>Sünniaasta</label>
			<input type="number" min="1914" max="2000" value="2000" name="birthyear">
			<input type="submit" name="submitUserData" value="Saada andmed">
		</form>
		
		<?php
		if(isset($_POST["birthyear"])){
			echo "<p>Oled elanud nendel aastatel: </p> \n";
			echo "<ol>\n";
				for ($i = $_POST["birthyear"]; $i <= date("Y"); $i++){
					echo "<li>". $i ."</li>\n";
				}	
			echo "</ol>\n";
		}
		?>
	<footer>
		<hr />
		<p>See leht on valminud õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
		<img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="Tallinna ülikool" width="300" height="150"><br />
		<a href="https://www.tlu.ee">TLÜ kodulehele saab siit</a>
	</footer>
	
	<script src="../force-https.js"></script> 
	</body>
</html>
