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
	
	function test_input($data) { // Sanitize input
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	
?>