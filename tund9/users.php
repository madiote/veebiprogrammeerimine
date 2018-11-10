<?php
	require("functions.php");
	require("header-account.php");

  $userlist = getuserlist($_SESSION["userId"]);

  $pageTitle = "Kasutajad";
	require("header.php");
?>
<ul><?php echo $userlist; ?></ul>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







