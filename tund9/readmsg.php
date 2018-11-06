<?php
	require("functions.php");
	$notice = readallmessages();
	
	$pageTitle = "Sõnumid";
	require("header.php");
?>
<!DOCTYPE html>
		<?php echo $notice; ?>
		
		<?php require("footer.php"); ?>
