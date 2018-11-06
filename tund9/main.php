<?php
  require("functions.php");

  // If not signed in
  if(!isset($_SESSION["userId"])){
	header("Location: index_2.php"); // redirect user back
	exit();
  }
  
  // When requesting signout
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index_2.php");
	exit();
	}
	
	//Get profile details
	$profiledetails = getuserprofile($_SESSION["userId"]);
	//print_r($profiledetails);
	
	// Use profile values if they exist
	if ($profiledetails != null){
		if ($profiledetails[1] != null){
			$_SESSION["foregroundcolor"] = $profiledetails[1];
		}
		
		if ($profiledetails[2] != null){
			$_SESSION["backgroundcolor"] = $profiledetails[2];
		}
	}

	$pageTitle = "Pealeht";
	require("header.php");
?>

	<hr><p>Olete sisseloginud nimega: <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>.</p> 
	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="userprofile.php">Sinu profiil</a></li>
		<li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
		<li><a href="validatedmessages.php">Vaata valideeritud sõnumeid</a></li>
		<li><a href="users.php">Kasutajate nimekiri</a></li>
		<li><a href="photoupload.php">Piltide üleslaadimine</a></li>
	</ul>

	<?php require("footer.php"); ?>
