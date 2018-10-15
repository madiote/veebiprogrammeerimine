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
  
  // Validate
  if(isset($_POST["submitValidation"])){
	validatemsg($_POST["id"], $_POST["validation"], $_SESSION["userId"]);
  }

  if(isset($_GET["id"])){
	 $msg = readmsgforvalidation($_GET["id"]); // show messages
  }
  else {
	header("Location: validatemsg.php"); // return if there is no more GET id
	exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="validatemsg.php">Tagasi</a> sõnumite lehele!</li>
  </ul>
  <hr>
  <h2>Valideeri see sõnum:</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
    <p><?php echo $msg; ?></p>
    <input type="radio" name="validation" value="0" checked><label>Keela näitamine</label><br>
    <input type="radio" name="validation" value="1"><label>Luba näitamine</label><br>
    <input type="submit" value="Kinnita" name="submitValidation">
  </form>
  <hr>
	<iframe src="../footer.html" frameBorder="0" height="auto" width="100%"></iframe>
	<script src="../../force-https.js"></script> <!-- Force HTTPS with javascript -->
</body>
</html>







