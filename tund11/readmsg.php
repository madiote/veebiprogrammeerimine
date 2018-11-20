<?php
	require("functions.php");
	require("header-account.php");

	$notice = readallmessages();
	
	$pageTitle = "Sõnumid";
	require("header.php");
?>
<?php echo $notice; ?>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
