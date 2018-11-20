<?php
	require("functions.php");
	require("header-account.php");

  $msglist = readallunvalidatedmessages();

  $pageTitle = "Anonüümsed sõnumid";
	require("header.php");
?>  
<?php echo $msglist; ?>

<?php require("footer-account.php"); ?>  
<?php require("footer.php"); ?>







