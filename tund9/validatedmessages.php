<?php
	require("functions.php");
	require("header-account.php");

  $msglist = readallvalidatedmessagesbyuser();
  $pageTitle = "Sõnumid";
	require("header.php");
?>
  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  <h2>Valideeritud sõnumid valideerijate kaupa</h2>
  <?php echo $msglist; ?>
  
  <?php require("footer.php"); ?>







