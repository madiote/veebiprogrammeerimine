<?php
	require("../../../config.php"); // Account details
	$database = "if18_madis_ot_1";
	
	function saveamsg($msg){
		$notice = "";
		// Create db connection
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		// Preparing db statement
		$stmt = $mysqli -> prepare("INSERT INTO vpamsg (message) VALUES(?)"); // Assign the command to mysqli, prepare statement for usage (without defined values)
		echo $mysqli->error; // Echo a mysqli error if any
		
		// Replace the statement question marks with values; first types, then data
		// s - string, i - integer, d - decimal
		$stmt -> bind_param("s", $msg); // Similar to string.format(); but requires types to be defined first
	
		if($stmt -> execute()){ // Execute db statement, check if valid
			$notice = 'Sõnum: "' . $msg . '" on edukalt salvestatud!';
		}
		else {
			$notice = 'Sõnumi salvestamisel tekkis tõrge: ' . $stmt -> error;
		}
		
		// Close the db
		$stmt -> close();
		// Close the connection
		$mysqli -> close();
		
		return $notice;
	}
	
	function readallmessages(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		
		$stmt -> bind_result($msg);
		if($stmt -> execute()){
			// Not sure how to write this negatively, maybe by wrapping in parenthesis?
		}
		else {
			$notice = 'Sõnumite saamisel tekkis tõrge: ' . $stmt -> error;
		}
		
		while ($stmt -> fetch()){
			$notice .= "<p>" . $msg . "</p> \n"; // .= means appending text
		}
		
		$stmt -> close();
		$mysqli -> close();
		
		return $notice;
	}
	
	function createAndFetchCats($catName, $catColor, $catTail){
		$notice = null;
		$cats = null;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		// Insert a cat
		if ($catName != null and $catColor != null){ // Only if there is input
			$stmt = $mysqli -> prepare("INSERT INTO kassid (nimi, v2rv, saba) VALUES(?, ?, ?)");
			echo $mysqli->error;
		
			$stmt -> bind_param("ssi", $catName, $catColor, $catTail);
	
			if($stmt -> execute()){
				$notice = 'Kass ' . $catName . ' on sisestatud!';
			}
			else {
				$notice = 'Kassi sisestamisel esines tõrge: ' . $stmt -> error; // Never displayed, why?
			}
			$stmt -> close();
		}
		else { // Otherwise skip
			$notice = "Kuvan tabelis olevaid kasse.";		
		}

		// Fetch the cats
		$stmt = $mysqli -> prepare("SELECT nimi, v2rv, saba FROM kassid ORDER BY kiisu_id");
		echo $mysqli->error;
		
		$stmt -> bind_result($readCatName, $readCatColor, $readCatTail);
		if($stmt -> execute()){
			// Do nothing if succeeded
		}
		else {
			$notice = 'Kasside saamisel esines tõrge: ' . $stmt -> error; 
		}
		
		while ($stmt -> fetch()){ // Too lazy for a 2-dimensional array, so separating with dashes
			$cats .= "<li>" . $readCatName . " - " . $readCatColor . " - " . $readCatTail . "</li>";
		}
		
		$stmt -> close();

		$mysqli -> close();
		return $cats . "|" . $notice; // Cannot return two variables properly
	}

	function test_input($data) { // Sanitize input
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	function signup($firstName, $lastName, $birthDate, $gender, $email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli -> error;
		
		// Krüpteerime parooli
		$options = ["cost" => 12, // Mitu ms kulub krüpteerimisele, 10 tavaline ja 12 max
					"salt" => substr(sha1(mt_rand()), 0, 22)]; // Hash'i juhuslik sool, võta 22 märki
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options); // Hangi parooli soolatud räsi bcrypt'ga
 		 
		$stmt -> bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $pwdhash);
		if($stmt -> execute()){
			$notice = "Kasutaja loomine õnnestus!";
		} else {
			$notice = "Kasutaja loomisel esines tõrge: " . $stmt -> error; 
		}
		
		$stmt -> close();
		$mysqli -> close();
		
		return $notice;
	}
	
?>
