<?php
	require("functions.php");
	require("header-account.php");

  $msglist = readallvalidatedmessagesbyuser();
  $pageTitle = "Sõnumid";
	require("header.php");
?>
<h2>Valideeritud sõnumid valideerijate kaupa</h2>
<?php echo $msglist; ?>

<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







