<?php
	//echo "See on minu esimene PHP!";
	$firstName = "Madis";
	$lastName = "Otenurm";
	
	$dirToRead = "../../pics/";
	$allFiles = scandir($dirToRead);
	//var_dump($allFiles);
	$picFiles = array_slice($allFiles, 2);
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
		<p>Tere tulemast fotosaidile! <a href="../tund3">Tagasi tund3 indeksile</a></p>
		<?php
			for ($i = 0; $i < count($picFiles); $i++){
				echo '<img src="' . $dirToRead . $picFiles[$i] . '" alt="Pilt" width="300" height="150">';
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
