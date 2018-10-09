<?php
  require("functions.php");

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
	  
	</ul>
	<iframe src="../footer.html" frameBorder="0" height="auto" width="100%"></iframe>
	<script src="../../force-https.js"></script> <!-- Force HTTPS with javascript -->
  </body>
</html>