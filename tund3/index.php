<?php
	//echo "See on minu esimene PHP!";
	$firstName = "Madis";
	$lastName = "Otenurm";
	//$dateToday = date("d.m.Y");
	$dayToday = date("d");
	$yearToday = date("Y");	
	$weekdayToday = date("N");
	$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$monthToday = date("m");
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "november", "detsember"];
	$hourNow = date("G");
	$minuteNow = date("i");
	$partOfDay = "";
	
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
	
	//var_dump($weekdayNamesET); // prindi kogu massiivi atribuudid
	//echo $weekdayNamesET[1]; //prindi teisipäev
	
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
		<p>Tere tulemast tund3 lehele! <a href="../index.php">Tund2 sait</a> <a href="photo.php">Fotosait</a> <a href="page.php">page.php</a></p>
		<?php
			//echo "<p>Täna on " . $dateToday . " kell " . $hourNow . ":" . $minuteNow . " (" . $partOfDay . " - " . $weekdayToday .  ").";
			echo "<p> Täna on " . $weekdayNamesET[$weekdayToday - 1] . ", " . $dayToday . ". " . $monthNamesET[$monthToday - 1] . " " . $yearToday . ".</p>";
		?><br />
		<img src = "<?php echo $picFile; ?>" alt = "Juhuslik pilt"> <br />
		<!-- <img src="../../kool.jpg" alt="Laps kirjutab" width="500" height="500"><br /> -->
		<a href=".">Laadi uus pilt</a><br />
		<a href="../../../../~kellrei/veebiprogrammeerimine/index.php" target="_blank">Minu sõber teeb ka veebi (PHP)</a><br />
	
	<footer>
		<hr />
		<p>See leht on valminud õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
		<img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="Tallinna ülikool" width="300" height="150"><br />
		<a href="https://www.tlu.ee">TLÜ kodulehele saab siit</a>
	</footer>
	
	<script src="../force-https.js"></script> 
	</body>
</html>
