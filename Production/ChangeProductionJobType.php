<?php
require_once 'Controller.php'; 

if(isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId'])  && isset($_REQUEST['production_job_type']) && !empty($_REQUEST['production_job_type'])) {

    $CTNId = $Controller->CleanInput($_REQUEST['CTNId']);
    $pjt = $Controller->CleanInput($_REQUEST['production_job_type']); 
    $update = $Controller->QueryData("UPDATE carton SET production_job_type = '". $pjt ."'  WHERE CTNId = ?", [$CTNId] ) ; 
    if($update)
     header('Location:JobManagement.php?CTNId='. $CTNId . '&msg=Job Type Changed &class=success');
    else header('Location:index.php?msg=something went wrong!&class=danger');

 

}

