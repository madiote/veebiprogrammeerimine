<?php 

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

$profilePicDirectory = "../vpuser_picfiles/";


// Use profile values if they exist
$myprofile = showmyprofile();
if($myprofile -> description != ""){
    $mydescription = $myprofile -> description;
}
if($myprofile -> bgcolor != ""){
    $mybgcolor = $myprofile -> bgcolor;
}
if($myprofile -> txtcolor != ""){
    $mytxtcolor = $myprofile -> txtcolor;
}
if($myprofile -> picture != ""){
    $profilePic = $profilePicDirectory . $myprofile -> picture;
}

?>