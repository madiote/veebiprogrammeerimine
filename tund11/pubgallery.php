<?php
    require("functions.php");
	require("header-account.php");

    $thumbs = allPublicPictureThumbsPage(2);

    $pageTitle = "Avalikud pildid";
    require("header.php");
?>
<?php echo $thumbs; ?>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







