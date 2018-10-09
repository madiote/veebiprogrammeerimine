<?php
  require("functions.php");

  // If not signed in
  if(!isset($_SESSION["userId"])){
	header("Location: index_2.php"); // redirect user back
	exit();
  }
  
  // When requesting signout
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index_2.php");
	exit();
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Pealeht</title>
  </head>
  <body>
    <h1>Pealeht</h1>
	<hr><p>Olete sisseloginud nimega: <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?>.</p> 
	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
	</ul>
	<iframe src="../footer.html" frameBorder="0" height="auto" width="100%"></iframe>
	<script src="../../force-https.js"></script> <!-- Force HTTPS with javascript -->
  </body>
</html>