<?php
	require("../../../config.php"); // Account details
	$database = "if18_madis_ot_1";
	
	// Using a session
	session_start();
	
	function getuserprofile($userId){
		$userprofile = array();
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT description, foreground, background FROM vpuserprofiles WHERE userid = ?");
		echo $mysqli -> error;
		
		$stmt->bind_param("i", $userId);
		$stmt->bind_result($descriptionFromDb, $foregroundFromDb, $backgroundFromDb);
		$stmt->execute();
		$stmt->fetch();
		
		// Set values to array
		array_push($userprofile, $descriptionFromDb, $foregroundFromDb, $backgroundFromDb);
		
		$stmt->close();
		$mysqli->close();
		return $userprofile;
	}
	
	function setuserprofile($userId, $description, $foreground, $background){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("REPLACE INTO vpuserprofiles (userid, description, foreground, background) VALUES (?, ?, ?, ?)"); // thanks SO https://stackoverflow.com/a/4205222 
		echo $mysqli -> error;
		
		$stmt->bind_param("isss", $userId, $description, $foreground, $background);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function validatemsg($id, $status, $userid){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id = ?");
		echo $mysqli -> error;
		
		$stmt->bind_param("iii", $userid, $status, $id);
		$stmt->bind_result($notice);
		$stmt->execute();
		
		if($stmt->fetch()){

		}
		else {
			$notice = "Sõnumi valideerimisel esines viga.";
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}

	function readmsgforvalidation($editId){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
		echo $mysqli -> error;
		
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($msg);
		$stmt->execute();
		
		if($stmt->fetch()){
			$notice = $msg;
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}

	function readallunvalidatedmessages(){
		$notice = "<ul> \n";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL"); //sort: ORDER BY id DESC
		echo $mysqli -> error;
		$stmt -> bind_result($msgid, $msg);
		
		if ($stmt -> execute()){
			while($stmt -> fetch()){
				$notice .= "<li>" . $msg . '<br><a href = "validatemessage.php?id=' . $msgid . '" >Valideeri</a></li>' . "\n";
			}
		}
		else {
			$notice .= "<li>Sõnumite lugemisel tekkis viga: " . $stmt -> error . "</li> \n";
		}
		
		$notice .= "</ul> \n";
		
		$stmt -> close();
		$mysqli -> close();
		
		return $notice;
	}

	function readallvalidatedmessagesbyuser(){
		$msghtml = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("SELECT id, firstname, lastname FROM vpusers"); 
		echo $mysqli -> error;
		$stmt -> bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);

		$stmt2 = $mysqli -> prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby = ?");
		$stmt2 -> bind_param("i", $idFromDb);
		$stmt2 -> bind_result($msgFromDb, $acceptedFromDb);
		
		$stmt -> execute();
		// Keep the result persistently usable in $stmt2
		$stmt -> store_result();

		while ($stmt -> fetch()){
			$userdata = "";
			$userdata .= "<h3>" . $firstnameFromDb . " " . $lastnameFromDb . "</h3> \n";
			$stmt2 -> execute();
			$counter = 0;
			while($stmt2 -> fetch()){
				$counter++;
				$userdata .= "<p><b>";
				if ($acceptedFromDb == 1){
					$userdata .= "✔️";
				}
				else {
					$userdata .= "❌";
				}
				$userdata .= "</b> " . $msgFromDb . "</p> \n";
			}

			if ($counter > 0){ // Add to HTML if the user did (in)validate messages
				$msghtml .= $userdata;
			}
		}
		$stmt2 -> close();
		$stmt -> close();
		$mysqli -> close();
		
		return $msghtml;
	}
	
	function allvalidmessages(){
		$notice = "";
		$accepted = 1;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE accepted=? ORDER BY accepted DESC");
		echo $mysqli -> error;
		
		$stmt->bind_param("i", $accepted);
		$stmt->bind_result($msg);
		$stmt->execute();
		
		while ($stmt -> fetch()){
			$notice .= "<p>" . $msg . "</p> \n";
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signin($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email = ?");
		echo $mysqli->error;
		
		$stmt -> bind_param("s", $email);
		$stmt -> bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
		
		if($stmt -> execute()){
			// DB request succeeded
			if($stmt -> fetch()){
				// User exists
				if(password_verify($password, $passwordFromDb)){
					// Password correct
					$notice = "Olete õnnelikult sisseloginud!";		
					// Set up session variables
					$_SESSION["userId"] = $idFromDb;
					$_SESSION["lastName"] = $lastnameFromDb;
					$_SESSION["firstName"] = $firstnameFromDb;
					
					// Close completed connections
					$stmt -> close(); 
					$mysqli -> close();
					
					// Redirect to file
					header("Location: main.php"); 
					exit();
				}
				else {
					$notice = "Kahjuks vale salasõna!";
				}
			}
			else {
				$notice = "Kahjuks sellise kasutajatunnusega (" . $email . ") kasutajat ei leitud.";
			}
		}
		else {
			$notice = "Sisselogimisel tekkis tehniline viga." . $stmt -> error;
		}
		$stmt -> close();
		$mysqli -> close();
		
		return $notice;
	}
	
	function getuserlist($currentUser){
		$notice = "";
		$firstname = "";
		$lastname = "";
		$email = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id != $currentUser");
		echo $mysqli -> error;
		
		$stmt->bind_result($firstname, $lastname, $email);
		$stmt->execute();
		
		while ($stmt -> fetch()){
			$notice .= "<li>" . $firstname . " " . $lastname . " (" . $email . ")</li> \n"; 
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
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
