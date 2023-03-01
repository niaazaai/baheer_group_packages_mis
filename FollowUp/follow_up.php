<?php
    require_once 'Controller.php'; 
 

    if( isset($_GET["Follow"]) && !empty($_GET["Follow"]) &&  isset($_GET["CTNId"]) && !empty($_GET["CTNId"]) ){

        $CTNId = $Controller->CleanInput($_GET['CTNId']); 
        $Follow = $Controller->CleanInput($_GET['Follow']); 

        if($Follow == 'Yes') {
            if($Controller->QueryData("UPDATE carton SET followed_up = 'Yes' WHERE CTNId = ? " , [ $CTNId  ])) {
                header('Location:internal_follow_up_center.php?msg=Followed up successfully&class=success'); 
            }
            else   header('Location:internal_follow_up_center.php?msg=Followed up failed&class=danger');
        } 
        else header('Location:internal_follow_up_center.php'); 
    }//end of first if 
    

    if( isset($_GET["Extend"]) && !empty($_GET["Extend"]) &&  isset($_GET["CTNId"]) && !empty($_GET["CTNId"]) ){

        $CTNId = $Controller->CleanInput($_GET['CTNId']); 
        $Extend = $Controller->CleanInput($_GET['Extend']); 

        if($Extend == 'Yes') {
            if($Controller->QueryData("UPDATE carton SET job_arrival_time=current_timestamp WHERE CTNId=?",[  $CTNId]) ) {
                header('Location:internal_follow_up_center.php?msg=Job Extended successfully&class=success'); 
            }
            else   header('Location:internal_follow_up_center.php?msg=Something went wrong !&class=danger');
        } 
        else header('Location:internal_follow_up_center.php'); 
    }//end of first if 
    else   header('Location:internal_follow_up_center.php');  
?>