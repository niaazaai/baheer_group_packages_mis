<?php
require_once 'Controller.php'; 
 
if(isset($_REQUEST['CTNId']) && !empty(trim($_REQUEST['CTNId']))   ) {
    $CTNId = $Controller->CleanInput($_REQUEST['CTNId']);
    $update_used_machine = $Controller->QueryData("UPDATE carton SET CTNStatus  = 'Completed'  WHERE CTNId = ?", [   $CTNId  ] );

    if($update_used_machine)   header('Location:AllJobs.php');
    else  header('Location:AllJobs.php&msg=somthing went wrong!&class=danager');
}