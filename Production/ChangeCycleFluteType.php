<?php
require_once 'Controller.php'; 

if(isset($_POST['CTNId']) && !empty(trim($_POST['CTNId']))  
&& isset($_POST['cycle_flute_type']) && !empty(trim($_POST['cycle_flute_type'])) 
&& isset($_POST['cycle_id']) && !empty(trim($_POST['cycle_id']))  ) {

    $CTNId = $Controller->CleanInput($_POST['CTNId']);
    $CYCLE_ID = $Controller->CleanInput($_POST['cycle_id']);

    $update_used_machine = $Controller->QueryData("UPDATE production_cycle SET cycle_flute_type  = '". $_POST['cycle_flute_type'] ."'  WHERE cycle_id = ?", [$CYCLE_ID]);
    if($update_used_machine) header('Location:JobManagement.php?msg=Flute type for the cycle updated!&class=success&CTNId='.$CTNId);
    else header('Location:JobManagement.php?msg=something went wrong!&class=danger&CTNId='.$CTNId);
    
} // END OF IF BLOCK 
else die('Somthing Went Wrong'); 

