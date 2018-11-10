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
    
//Get profile details
$profilepicpath = "../vp_profilepic_uploads/";
$noprofilepic = "../vp_picfiles/vp_user_generic.png";
$profiledetails = getuserprofile($_SESSION["userId"]);

// Use profile values if they exist
if ($profiledetails != null){
    if ($profiledetails[0] != null){
        $picfile = getProfilePicFileById($profiledetails[0]);
        if ($picfile != null){
            $profilepic = $profilepicpath . $picfile;
        }
        else {
            $profilepic = $profilepicpath . $noprofilepic;
        }
        $_SESSION["profilepic"] = $profilepic;
    }

    if ($profiledetails[1] != null){
        $descriptiontext = $profiledetails[1];
        //$_SESSION["description"] = $descriptiontext;
	    //Uncomment if you need the description text in session
    }

    if ($profiledetails[2] != null){
        $foregroundcolor = $profiledetails[2];
        $_SESSION["foregroundcolor"] = $foregroundcolor;
    }
    
    if ($profiledetails[3] != null){
        $backgroundcolor = $profiledetails[3];
        $_SESSION["backgroundcolor"] = $backgroundcolor;
    }
}

?>