<?php 
require_once 'Controller.php';

if( isset($_GET['cycle_id']) && trim(!empty($_GET['cycle_id']))  &&  isset($_GET['machine_id']) && trim(!empty($_GET['machine_id']))   ) {
    $machine_id = $Controller->CleanInput($_GET['machine_id']); 
    $cycle_id = $Controller->CleanInput($_GET['cycle_id']); 
    $CTNId = $Controller->CleanInput($_GET['CTNId']); 
    $Delete  = $Controller->QueryData('Delete FROM used_machine WHERE cycle_id = ? AND machine_id = ?', [$cycle_id , $machine_id ]);
    if($Delete)  header('Location:ManualCycle.php?msg=Machine removed successfully &class=success') ;
    else header('Location:ManualCycle.php?msg=Somthing went wrong &class=danger') ;
} // END IF BLOCK 

