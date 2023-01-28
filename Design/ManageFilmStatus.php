<?php 
    require_once 'Controller.php'; 
    if(isset($_POST['DesignId']) && !empty($_POST['DesignId']) && isset($_POST['CTNId']) && !empty($_POST['CTNId'])) { 

        $CTNId  = $Controller->CleanInput($_POST['CTNId']); 
        $DesignId = $Controller->CleanInput($_POST['DesignId']); 
     
        $flag = true; 

        $Info = $Controller->QueryData("UPDATE designinfo set film_status = 'Complete' , film_complete_date = CURRENT_TIMESTAMP WHERE DesignId = ? ",[$DesignId]); 
        if(!$Info) $flag = false; 

        $carton = $Controller->QueryData("UPDATE carton set CTNStatus = 'Archive'  WHERE CTNId = ? ",[$CTNId]) ; 
        if(!$carton) $flag = false; 

        if($flag) header('Location:Film.php?msg=Job has been sent to Archeive Department&class=success'); 
        else header('Location:Film.php?msg=Something went wrong &class=danger'); 
    }// end of gatepass block 
    else header('Location:Film.php?msg=Post Not Complete&class=danger'); 

