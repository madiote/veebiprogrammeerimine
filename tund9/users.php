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

  $pageTitle = "Kasutajad";
	require("header.php");
?>

  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  <ul><?php echo $userlist; ?></ul>
  
  <?php require("footer.php"); ?>







