<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<title>VP <?php echo $pageTitle ?></title>
        <link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
		<style>
			body {
				background-color: <?php echo $_SESSION["bgColor"]; ?>;
				color: <?php echo $_SESSION["txtColor"]; ?>
			}
		</style>
        <?php
            if(isset($scripts)){
                echo $scripts;
            }
        ?>
  </head>
  <body>
		<div>
			<a href="main.php">
				<img src="../vp_picfiles/vp_logo_w135_h90.png" alt="Veebiprogrammeerimine 2018">
				<img src="../vp_picfiles/vp_banner.png" alt="Veebiprogrammeerimine 2018">
			</a>
		</div>

    <h1><?php echo $pageTitle ?></h1>