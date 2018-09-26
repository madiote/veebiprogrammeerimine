<?php
	require("functions.php");
	$catName = null;
	$catColor = null;
	$catTail = null;
	$combined = createAndFetchCats(null, null, null); // Show the list initially without sending data
	$notice = null;
	$cats = null;
	$combinedSplit = null;

	if (isset($_POST["submitCat"])){
		if (!empty($_POST["catName"]) and !empty($_POST["catColor"])){
			$catName = test_input($_POST["catName"]);
			$catColor = test_input($_POST["catColor"]);
			$catTail = test_input($_POST["catTail"]);
			$combined = createAndFetchCats($catName, $catColor, $catTail);
		} else {
			$combined = createAndFetchCats(null, null, null);
		}
	}

	if (!empty($combined)){ // Parse received string for cats and notice
		$combinedSplit = explode('|', $combined);
	}
	
	$notice = $combinedSplit[1]; // Notice comes after cats
	$cats = $combinedSplit[0];
	
?>
<!DOCTYPE html>

<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>Kassid</title>
		<link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
	</head>

	<body>
		<h1>Kassid</h1>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Kassi nimi:</label>
			<input type="text" name="catName">
			<label>Kassi värv:</label>
			<input type="text" name="catColor">
			<label>Kassi saba pikkus:</label>
			<input type="number" name="catTail" min="1" max="99999999999" value="1"> <!-- int(11) in db -->
			<input type="submit" name="submitCat" value="Sisesta">
		</form>
		<?php 
			echo "<p>" . $notice . "</p>"; 
			echo "<ol>" . $cats . "</ol>"; 
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
