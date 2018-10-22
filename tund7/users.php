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
	
  $userlist = getuserlist($_SESSION["userId"]);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kasutajate nimekiri</title>
  <style>
			body {
				background-color: <?php echo $_SESSION["backgroundcolor"]; ?>;
				color: <?php echo $_SESSION["foregroundcolor"]; ?>
			} 
		</style>
</head>
<body>
  <h1>Kasutajad</h1>
  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  <ul><?php echo $userlist; ?></ul>
  
  <iframe src="../footer.html" frameBorder="0" height="auto" width="100%"></iframe>
  <script src="../../force-https.js"></script> <!-- Force HTTPS with javascript -->
</body>
</html>







