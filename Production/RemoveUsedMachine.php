<?php 
require_once 'Controller.php';

if( isset($_POST['cycle_id']) && trim(!empty($_POST['cycle_id']))  &&
    isset($_POST['machine_id']) && trim(!empty($_POST['machine_id']))   ) {
    $machine_id = $Controller->CleanInput($_POST['machine_id']); 
    $cycle_id = $Controller->CleanInput($_POST['cycle_id']); 
    $CTNId = $Controller->CleanInput($_POST['CTNId']); 
    $Delete  = $Controller->QueryData('Delete FROM used_machine WHERE cycle_id = ? AND machine_id = ?', [$cycle_id , $machine_id ]);
    if($Delete)  header('Location:JobManagement.php?CTNId='.$CTNId.'&msg=Machine removed &class=success') ;
    else header('Location:JobManagement.php?CTNId='.$CTNId.'&msg=Somthing went wrong &class=danger') ;
} // END IF BLOCK 





if( isset($_POST['cycle_id_main']) && trim(!empty($_POST['cycle_id_main']))  && isset($_POST['CTNId']) && trim(!empty($_POST['CTNId']))   ) {
    
    $cycle_id = $Controller->CleanInput($_POST['cycle_id_main']); 
    $CTNId = $Controller->CleanInput($_POST['CTNId']); 
    $Delete  = $Controller->QueryData('Delete FROM production_cycle WHERE cycle_id = ?', [$cycle_id]);
    if($Delete) header('Location:JobManagement.php?CTNId='.$CTNId.'&msg=Cycle removed &class=success') ;
    else header('Location:JobManagement.php?CTNId='.$CTNId.'&msg=Somthing went wrong &class=danger') ;

}
else  header('Location:JobManagement.php?CTNId='.$CTNId.'&msg=Somthing went wrong &class=danger') ;

?>