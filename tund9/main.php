<?php
	require("functions.php");
	require("header-account.php");
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
