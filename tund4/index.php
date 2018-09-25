<?php
	$firstName = "Madis";
	$lastName = "Otenurm";
	
	$dayToday = date("d");
	$weekdayToday = date("N");
	$monthToday = date("m");
	$yearToday = date("Y");	
	$hourNow = date("G");
	$minuteNow = date("i");
	$partOfDay = "";
	
	$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	
	if ($hourNow < 8){
		$partOfDay = "varajane hommik";
	}
	elseif ($hourNow >= 8 and $hourNow <= 16){
		$partOfDay = "koolipäev";
	}
	elseif ($hourNow > 16){
		$partOfDay = "vaba aeg";
	}
	else {
		$partOfDay = "öö";
	}
	
	//juhuslik pilt
	$picURL = "https://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	$picEXT = ".jpg";
	$picNUM = mt_rand(2,42);
	$picFile = $picURL . $picNUM . $picEXT;
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
		<p>Tere tulemast tund4 lehele! <a href="../index.php">Tund2 sait</a> <a href="photo.php">Fotosait</a> <a href="photo2.php">Fotosait 2</a> <a href="page.php">page.php</a></p>
		<?php
			echo "<p> Täna on " . $weekdayNamesET[$weekdayToday - 1] . ", " . $dayToday . ". " . $monthNamesET[$monthToday - 1] . " " . $yearToday . ".</p>";
		?><br />
		<img src = "<?php echo $picFile; ?>" alt = "Juhuslik pilt"> <br />
		<a href=".">Laadi uus pilt</a><br />
		<a href="../../../../~kellrei/veebiprogrammeerimine/index.php" target="_blank">Minu sõber teeb ka veebi (PHP)</a><br />
	
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
