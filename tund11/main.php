<?php
	require("functions.php");
	require("header-account.php");
	$pageTitle = "Pealeht";
	require("header.php");
?>
<ul>
	<li><a href="userprofile.php">Sinu profiil</a></li>
	<li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
	<li><a href="validatedmessages.php">Vaata valideeritud sõnumeid</a></li>
	<li><a href="users.php">Kasutajate nimekiri</a></li>
	<li><a href="photoupload.php">Piltide üleslaadimine</a></li>
    <li><a href="pubgallery.php">Avalike fotode galerii</a></li>
</ul>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>
