<?php
require("../../../config.php"); // Account details
$database = "if18_madis_ot_1";
session_start();
$filename = $_REQUEST["filename"];

$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
$stmt = $mysqli -> prepare("SELECT id FROM vpphotos WHERE filename = ?");
echo $mysqli -> error;

$stmt -> bind_param("i", $filename);
$stmt -> bind_result($id);
$stmt -> execute();
$stmt -> fetch();
$stmt -> close();

$mysqli -> close();
echo $id;
?>