<?php
	//echo "See on minu esimene PHP!";
	$firstName = "Madis";
	$lastName = "Otenurm";
	$dateToday = date("d.m.Y");
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
		<p>Tere tulemast PHP lehele! <a href="../index.html">Tavasaidile saab siit</a></p>
		<?php
			echo "<p>Täna on " . $dateToday . " kell " . $hourNow . ":" . $minuteNow . " (" . $partOfDay . ").";
		?><br />
		<img src="../kool.jpg" alt="Laps kirjutab" width="500" height="500"><br />
		<a href="../../~kellrei/veebiprogrammeerimine/index.php" target="_blank">Minu sõber teeb ka veebi (PHP)</a><br />
		<p>Tasuta HTTPS kõigile! Lisa see oma lehele: </p>
		<textarea rows="1" cols="50" readonly><script src="../~madiote/force-https.js"></script></textarea>
	
	<footer>
		<hr />
		<p>See leht on valminud õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
		<img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="Tallinna ülikool" width="300" height="150"> <a href="https://www.tlu.ee">TLÜ kodulehele saab siit</a>
	</footer>
	
	<script src="force-https.js"></script> 
	</body>
</html>