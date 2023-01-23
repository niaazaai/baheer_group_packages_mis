<?php  
    session_start(); 
    require 'Controller.php'; 
    if( isset($_REQUEST['CTNId']) && !empty(trim($_REQUEST['CTNId']))  ) {
        $CartonID = $Controller->CleanInput($_REQUEST['CTNId']); 
        $create_cycle  = $Controller->QueryData('INSERT INTO production_cycle (CTNId , created_by ) VALUES(? , ?) ',[$CartonID , $_SESSION['EId']]);
        if($create_cycle){
            // $Last_Cycle_id = $DATABASE->last_id();  
            header("Location:JobManagement.php?CTNId=".$CartonID."&msg=New Cycle Created&class=success"); 
        }// end of create cycle 
        else header("Location:JobManagement.php?CTNId=".$CartonID ."&msg=Cycle did not registered&class=danger");
    }  
?>
