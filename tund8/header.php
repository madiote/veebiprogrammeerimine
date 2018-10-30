<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
		<title>VP <?php echo $pageTitle ?></title>
        <link rel="icon" href="https://www.tlu.ee/themes/tlu/images/favicons/favicon-32x32.png" type="image/png" sizes="16x16">
		<style>
			body {
				background-color: <?php echo $_SESSION["backgroundcolor"]; ?>;
				color: <?php echo $_SESSION["foregroundcolor"]; ?>
			} 
		</style>
  </head>
  <body>
		<div>
			<a href="main.php">
				<img src="../vp_picfiles/vp_logo_w135_h90.png" alt="Veebiprogrammeerimine 2018">
			</a>
			<img src="../vp_picfiles/vp_banner.png" alt="Veebiprogrammeerimine 2018">
		</div>

    <h1><?php echo $pageTitle ?></h1>