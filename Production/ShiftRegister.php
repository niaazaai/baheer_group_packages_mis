<?php 

require_once 'Controller.php'; 

if(
    isset($_REQUEST['machine_id']) && !empty($_REQUEST['machine_id']) && 
    isset($_REQUEST['cycle_id']) &&  !empty($_REQUEST['cycle_id']) && 
    isset($_REQUEST['CTNId']) && !empty($_REQUEST['CTNId']) &&
    isset($_REQUEST['EId']) &&  !empty($_REQUEST['EId'])) {

    $double_job = '-1'  ; 
    if(isset($_REQUEST['double_job']) && !empty($_REQUEST['double_job'])) {
        $double_job = $_REQUEST['double_job'];
    }

    // var_dump($_REQUEST); 

    $Row = $Controller->QueryData('SELECT * FROM machine_shift_history 
    WHERE CTNId = ? AND cycle_id = ? AND machine_id = ? AND EId = ?',
    [$_REQUEST['CTNId'] ,$_REQUEST['cycle_id'] ,$_REQUEST['machine_id'] , $_REQUEST['EId'] ]);
    
    if($Row->num_rows > 0 ) {
        header("Location:JobProcess.php?msg=Shift already exist&class=danger&CTNId=" .$_REQUEST['CTNId'] ."&CYCLE_ID=" .$_REQUEST['cycle_id'] ."&machine_id=" .$_REQUEST['machine_id'] ."&double_job=" . $double_job ); 
    }
    else {
        $con = $Controller->QueryData('INSERT INTO machine_shift_history (`CTNId`, `cycle_id`, `machine_id`, `EId`, `produced_qty`, `wast`, `labor`, `start_date`, `end_date` )
        VALUES (?,?,?,?,?,?,?,?,?)',
        [
            $_REQUEST['CTNId'] ,$_REQUEST['cycle_id'] ,$_REQUEST['machine_id'] , $_REQUEST['EId'] , 
            $_REQUEST['produced_qty'] ,$_REQUEST['wast'] ,$_REQUEST['labor'] , 
            gmdate("Y-m-d H:i:s", $_REQUEST['start_date']) ,date("Y-m-d H:i:s") 
        ]);

        if($con) {
            header("Location:JobProcess.php?msg=shift changed successfully&class=success&CTNId=" .$_REQUEST['CTNId'] ."&CYCLE_ID=" .$_REQUEST['cycle_id'] ."&machine_id=" .$_REQUEST['machine_id'] ."&double_job=" . $double_job );
        }
        else  header("Location:JobProcess.php?msg=Somthing went wrong&class=danger&CTNId=" .$_REQUEST['CTNId'] ."&CYCLE_ID=" .$_REQUEST['cycle_id'] ."&machine_id=" .$_REQUEST['machine_id'] ."&double_job=" . $double_job ); 
    }
}



?>