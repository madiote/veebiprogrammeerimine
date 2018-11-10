<?php
	require("functions.php");
	require("header-account.php");

  $userlist = getuserlist($_SESSION["userId"]);

  $pageTitle = "Kasutajad";
	require("header.php");
?>

  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  <ul><?php echo $userlist; ?></ul>
  
  <?php require("footer.php"); ?>







