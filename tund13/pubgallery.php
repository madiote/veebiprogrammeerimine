<?php
    require("functions.php");
	require("header-account.php");

    // When requesting signout
    if(!isset($_GET["page"])){ // if there is no page parameter, append one
        header("Location: ?page=0");
    }

    $totalPics = allPictureCount(2);
    $picsPerPage = 5;
	$currentPage = $_GET["page"];
	$totalPages = round($totalPics / $picsPerPage) - 1; // How many pages are needed to display all images, -1 because we currently also show zero
    $picsLeft = $totalPics - ($currentPage * $picsPerPage); // How many images are left to display

    $startAt = $currentPage * $picsPerPage;

    if ($_GET["page"] > $totalPages){ // Go to last page if the user set too large number
        header("Location: ?page=" . $totalPages);
    }

    if ($picsLeft < $picsPerPage){ // if there are less images to display than $perPage, use the real count to prevent errors
        $thumbs = allPublicPictureThumbsPage(2, $startAt, $picsLeft);
    }
    else {
        $thumbs = allPublicPictureThumbsPage(2, $startAt, $picsPerPage);
    }

    if ($currentPage > 0){
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
    $scripts = '<link rel="stylesheet" type="text/css" href="style/modal.css">' . "\n";
    $scripts .= '<script type="text/javascript" src="javascript/modal.js" defer></script>' . "\n";
require("header.php");
?>
<div id="gallery">
    <?php echo $thumbs . "<br>\n" .
        "<p>Leht " . $currentPage . "/" . $totalPages . " " . $pageBack . $pageForward . "</p>"; ?>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- The Close Button -->
    <span class="close">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="modalImg">

    <!-- Modal Caption (Image Text) -->
    <div id="caption" class="caption"></div>
    <div id="rating" class="caption">
        <label><input type="radio" name="rating" id="rating1" value="1">1</label>
        <label><input type="radio" name="rating" id="rating2" value="2">2</label>
        <label><input type="radio" name="rating" id="rating3" value="3">3</label>
        <label><input type="radio" name="rating" id="rating4" value="4">4</label>
        <label><input type="radio" name="rating" id="rating5" value="5">5</label>
        <input type="button" value="Hinda" id="storerating">
        <span id="avgRating"></span>
    </div>
</div>
<?php require("footer-account.php"); ?>
<?php require("footer.php"); ?>







