<?php
    require("../../../config.php"); // Account details
    $database = "if18_madis_ot_1";

    $privacy = 2;
    $limit = 10;
    $html = NULL;
    $photoList = [];

    $mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
    $stmt = $mysqli -> prepare("SELECT filename, alttext FROM vpphotos WHERE privacy <= ? AND deleted IS NULL ORDER BY id DESC LIMIT ?");
    echo $mysqli -> error;

    $stmt -> bind_param("ii", $privacy, $limit);
    $stmt -> bind_result($filenameFromDb, $alttextFromDb);
    $stmt -> execute();

    while ($stmt -> fetch()){
        $myPhoto = new StdClass();
        $myPhoto -> filename = $filenameFromDb;
        $myPhoto -> alttext = $alttextFromDb;
        array_push($photoList, $myPhoto);
    }

    $photoCount = count($photoList);

    if($photoCount > 0){
        $randPic = mt_rand(0, $photoCount - 1);
        $html = '<img src = "' . $picDir . $photoList[$randPic] -> filename . '" alt = "'
                                         . $photoList[$randPic] -> alttext . '">' . "\n";
    }

    // Print image list
    
    foreach($photoList as $pic){
        $html .= "<p>" . $pic -> filename .  " | " . $pic -> alttext . "</p> \n";
    }


    $stmt -> close();
    $mysqli -> close();

    echo $html;
?>