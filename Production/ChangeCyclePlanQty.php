<?php
require_once 'Controller.php'; 

if(isset($_POST['CTNId']) && !empty(trim($_POST['CTNId']))  
&& isset($_POST['cycle_id_for_plan_qty']) && !empty(trim($_POST['cycle_id_for_plan_qty'])) 
&& isset($_POST['cycle_plan_qty_input']) && !empty(trim($_POST['cycle_plan_qty_input']))  ) {

    $CTNId = $Controller->CleanInput($_POST['CTNId']);
    $CYCLE_ID = $Controller->CleanInput($_POST['cycle_id_for_plan_qty']);

    $cycle_plan_qty = $Controller->QueryData("UPDATE production_cycle SET cycle_plan_qty  = ? WHERE cycle_id = ?", [$_POST['cycle_plan_qty_input'] , $CYCLE_ID]);
    if($cycle_plan_qty) header('Location:JobManagement.php?msg=Plan quantity for the cycle updated!&class=success&CTNId='.$CTNId);
    else header('Location:JobManagement.php?msg=something went wrong!&class=danger&CTNId='.$CTNId);
    
} // END OF IF BLOCK 
else die('Somthing Went Wrong'); 

