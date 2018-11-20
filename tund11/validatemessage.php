<?php
	require("functions.php");
	require("header-account.php");
  
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

  $pageTitle = "Anonüümsed sõnumid";
	require("header.php");
?>
<h2>Valideeri see sõnum:</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
  <p><?php echo $msg; ?></p>
  <input type="radio" name="validation" value="0" checked><label>Keela näitamine</label><br>
  <input type="radio" name="validation" value="1"><label>Luba näitamine</label><br>
  <input type="submit" value="Kinnita" name="submitValidation">
</form>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







