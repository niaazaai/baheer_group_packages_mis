<?php
require_once 'Controller.php'; 

if( isset($_POST['CTNId']) && !empty(trim($_POST['CTNId']))  
    && isset($_POST['cycle_id_for_plan_qty']) && !empty(trim($_POST['cycle_id_for_plan_qty'])) 
    && isset($_POST['cycle_plan_qty_input']) && !empty(trim($_POST['cycle_plan_qty_input'])) 
    && isset($_POST['apps']) && !empty(trim($_POST['apps'])) ) {


    
    $CTNId = $Controller->CleanInput($_POST['CTNId']);
    $CYCLE_ID = $Controller->CleanInput($_POST['cycle_id_for_plan_qty']);
    $App = $Controller->CleanInput($_POST['apps']);
 
    // this is used for cut qty calculation 
    $cut_qty = $_POST['cycle_plan_qty_input'] / $App; 
    $percentage = $cut_qty / 100 ;
    $cut_qty += $percentage; 

    $cycle_plan_qty = $Controller->QueryData("UPDATE production_cycle SET cycle_plan_qty  = ?, cut_qty = ? WHERE cycle_id = ?", [$_POST['cycle_plan_qty_input'] ,$cut_qty ,$CYCLE_ID]);
    if($cycle_plan_qty) header('Location:JobManagement.php?msg=Plan quantity for the cycle updated!&class=success&CTNId='.$CTNId);
    else header('Location:JobManagement.php?msg=something went wrong!&class=danger&CTNId='.$CTNId);
    
} // END OF IF BLOCK 
else die('Somthing Went Wrong'); 

