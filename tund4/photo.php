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
		
		<p>Tere tulemast fotosaidile!</p>
		<?php
			for ($i = 0; $i < count($picFiles); $i++){
				echo '<img src="' . $dirToRead . $picFiles[$i] . '" alt="Pilt" width="300" height="150">';
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
