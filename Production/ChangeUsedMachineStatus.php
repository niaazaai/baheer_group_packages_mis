<?php
require_once 'Controller.php'; 

if(isset($_REQUEST['machine_id']) && !empty($_REQUEST['machine_id']) && 
isset($_REQUEST['cycle_id']) &&  !empty($_REQUEST['cycle_id'])  ) {

    $double_job = '-1'  ; 
    if(isset($_REQUEST['double_job']) && !empty($_REQUEST['double_job'])) {
        $double_job = $_REQUEST['double_job'];
    }

    $number_labor = (int) $Controller->CleanInput($_REQUEST['number_labor']);
    $machine_id = $Controller->CleanInput($_REQUEST['machine_id']);

    // var_dump($_REQUEST['wast_qty']); 
    // die(); 
    
    $flag = true; 
    foreach ($_REQUEST['cycle_id'] as $key => $cycle_id) {

        $cycle_id = $Controller->CleanInput( $cycle_id);
        $CTNId = $Controller->CleanInput($_REQUEST['CTNId'][$key]);
        $produced_qty = (int) $Controller->CleanInput($_REQUEST['produced_qty'][$key]);
        $wast_qty = (int) $Controller->CleanInput($_REQUEST['wast_qty'][$key]);

        $update_used_machine = $Controller->QueryData("UPDATE used_machine 
        SET `status` = 'Proccessed'  , 
        produced_qty=?, 
        wast_qty=? ,
        number_labor=?  
    
         WHERE cycle_id = ? AND  machine_id = ? ", 
        [  
            $produced_qty ,
            $wast_qty , 
            $number_labor ,
            $cycle_id , 
            $machine_id
        ] );

        if(!$update_used_machine)  { 
            $flag = false; 
        }
    }

    if($flag)  { 
        // header('Location:JobProcess.php?CTNId='. $_REQUEST['CTNId'][0] .'&CYCLE_ID='.$_REQUEST['cycle_id'][0] . '&machine_id=' . $machine_id .'&double_job='.$double_job   );
        header('Location:JobUnderProcess.php');

    }
    else {
        die('<h3> Somthing Went Wrong</h3>'); 
    }

    // echo $produced_qty; echo "<br>";
    // echo $wast_qty ;echo "<br>"; 
    // echo $number_labor; echo "<br>";
    // echo "<br>"; 
    // var_dump($produced_qty);
}