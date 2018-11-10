<?php
	require("functions.php");
	require("header-account.php");

  $msglist = readallunvalidatedmessages();

  $pageTitle = "Anonüümsed sõnumid";
	require("header.php");
?>

  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  
  <?php echo $msglist; ?>
  
  <?php require("footer.php"); ?>







