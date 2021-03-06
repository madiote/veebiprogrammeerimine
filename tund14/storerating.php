<?php
require("../../../config.php"); // Account details
$database = "if18_madis_ot_1";
session_start();
$id = $_REQUEST["id"];

if(empty($_REQUEST["rating"])){
    $rating = null;
}
else {
    $rating = $_REQUEST["rating"];
}

$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

if($rating != null) {
    $stmt = $mysqli->prepare("INSERT INTO vpphotoratings (photoid, userid, rating) VALUES(?,?,?)");
    echo $mysqli->error;

    $stmt->bind_param("iii", $id, $_SESSION["userId"], $rating);
    $stmt->execute();
    $stmt->close();
}


$stmt = $mysqli -> prepare("SELECT AVG(rating) FROM vpphotoratings WHERE photoid = ?");
echo $mysqli -> error;

$stmt -> bind_param("i", $id);
$stmt -> bind_result($score);
$stmt -> execute();
$stmt -> fetch();
$stmt -> close();

$mysqli -> close();
echo round($score, 2);
?>