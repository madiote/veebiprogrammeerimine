<?php
	require("functions.php");
	require("header-account.php");

    $expiredate = date("Y-m-d");
    $pageTitle = "Uudised";
    $title = "";
    $message = "";
    $expire = "";
    $notice = "";

    if(isset($_POST["newsBtn"])) {
        if (!empty($_POST["newsTitle"]) and !empty($_POST["newsEditor"]) and !empty($_POST["expiredate"])){
            $title = test_input($_POST["newsTitle"]);
            $message = $_POST["newsEditor"]; // Presumably TinyMCE does its own checks
            $expire = $_POST["expiredate"];
        }
        else {
            $notice = "Üks või mitu välja on tühjad!";
        }

        if (empty($notice)){
            addNewsPost($title, $message, $expire);
        }
    }

    $news = getTimelyNews($expiredate);

    // Using TinyMCE for text input
    $scripts = '<script src="https://cdn.tinymce.com/4/tinymce.min.js"></script><script>tinymce.init({selector:"textarea#newsEditor",plugins:"link",menubar:"edit"});</script>';
	require("header.php");
?>
<h2>Uus uudis</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value=""><br>
    <label>Uudise sisu:</label><br>
    <textarea name="newsEditor" id="newsEditor"></textarea>
    <br>
    <label>Uudis nähtav kuni (k.a.)</label>
    <input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $expiredate ?>">
    <input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis!">
</form>
<p><?php echo $notice; ?></p>
<h2>Kehtivad uudised</h2>
<?php echo $news; ?>

<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







