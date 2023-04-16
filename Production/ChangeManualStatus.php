<?php 
require_once 'Controller.php';

if( isset($_GET['cycle_id']) && trim(!empty($_GET['cycle_id']))) {
    $cycle_id = $Controller->CleanInput($_GET['cycle_id']); 
    // $CTNId = $Controller->CleanInput($_POST['CTNId']); && isset($_POST['CTNId']) && trim(!empty($_POST['CTNId'])) 
    $Delete  = $Controller->QueryData('UPDATE production_cycle SET manual_status = "Complete"  WHERE cycle_id = ? ', [$cycle_id]);
    if($Delete) header('Location:ManualCycle.php?msg=Cycle Done &class=success') ;
    else header('Location:ManualCycle.php?msg=Something went wrong &class=danger') ;
}
else  header('Location:ManualCycle.php?msg=Something went wrong &class=danger') ;