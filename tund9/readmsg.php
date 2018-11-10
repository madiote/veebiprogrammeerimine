<?php
	require("functions.php");
	require("header-account.php");

	$notice = readallmessages();
	
	$pageTitle = "Sõnumid";
	require("header.php");
?>
<!DOCTYPE html>
		<?php echo $notice; ?>
		
		<?php require("footer.php"); ?>
