<?php
  require("functions.php");
  $notice = "";
  $email = "";
  $emailError = "";
  $passwordError = "";
  
  if(isset($_POST["login"])){
	if (isset($_POST["email"]) and !empty($_POST["email"])){
	  $email = test_input($_POST["email"]);
    } else {
	  $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
    }
  
    if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
	  $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
    }
  
  if(empty($emailError) and empty($passwordError)){
	 $notice = signin($email, $_POST["password"]);
	 } else {
	  $notice = "Ei saa sisse logida!";
   }
  
	}
	$pageTitle = "Katseline veeb";
	require("header.php");
?>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email" value="<?php echo $email; ?>">&nbsp;<span><?php echo $emailError; ?></span><br>
	  
	  <label>Salasõna:</label><br>
	  <input name="password" type="password">&nbsp;<span><?php echo $passwordError; ?></span><br>
	  
	  <input name="login" type="submit" value="Logi sisse">&nbsp;<span><?php echo $notice; ?>
	</form>
	<p><a href="newuser.php">Loo kasutaja</a>!</p>
	<p><a href="addmsg.php">Lisa sõnum</a>!</p>
	<hr>
	<div>
	<h2>Anonüümsed postitused</h2>
	  <?php echo allvalidmessages(); ?>
	</div>
	
	<?php require("footer.php"); ?>
