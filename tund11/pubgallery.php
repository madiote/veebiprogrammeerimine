<?php
    require("functions.php");
	require("header-account.php");

    // When requesting signout
    if(!isset($_GET["page"])){ // if there is no page parameter, append one
        header("Location: ?page=1");
        exit();
    }

    $totalPics = allPictureCount(2);
    $startAt = 0;
    $picsPerPage = 5;
	$currentPage = $_GET["page"];
	$totalPages = round($totalPics / $picsPerPage); // How many pages are needed to display all images
	$picsLeft = $totalPics - ($currentPage * $picsPerPage); // How many images are left to display

    $startAt = $currentPage * $picsPerPage;

    if ($picsLeft < $picsPerPage){ // if there are less images to display than $perPage, use the real count to prevent errors
        $thumbs = allPublicPictureThumbsPage(2, $startAt, $picsLeft);
    }
    else {
        $thumbs = allPublicPictureThumbsPage(2, $startAt, $picsPerPage);
    }

    if ($currentPage > 1){
        $pageBack = '<a href="?page=' . ($currentPage - 1) . '">&#x3C; Eelmised</a>';
    }
    else {
        $pageBack = null;
    }

    if ($currentPage < $totalPages){
        $pageForward = ' <a href="?page=' . ($currentPage + 1) . '">Järgmised &#x3E;</a>';
    }
    else {
        $pageForward = null;
    }

    $pageTitle = "Avalikud pildid";
    require("header.php");
?>
<?php echo $thumbs . "<br>\n" . "<p>Leht " . $currentPage . "/" . $totalPages . " " . $pageBack . $pageForward . "</p>"; ?>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







