<?php
    require_once 'Controller.php'; 
 
    if( isset($_GET['umid']) && !empty($_GET['umid'])  && isset($_GET['CTNId']) && !empty($_GET['CTNId'])  ) {
         
            $umid = $Controller->CleanInput($_GET['umid']);
            $CTNId = $Controller->CleanInput($_GET['CTNId']);
            $update_used_machine = $Controller->QueryData("UPDATE used_machine SET status  = 'Complete' WHERE id = ?", [$umid] );
            if($update_used_machine) header('Location:JobManagement.php?CTNId='. $CTNId .'&msg=Machine Marked as Complete&class=success');
            else die('Something went wrong');

    }


    if( isset($_GET['cycle_id']) && !empty($_GET['cycle_id'])  && isset($_GET['CTNId']) && !empty($_GET['CTNId'])  ) {
         
        $umid = $Controller->CleanInput($_GET['cycle_id']);
        $CTNId = $Controller->CleanInput($_GET['CTNId']);
        $update_used_machine = $Controller->QueryData("UPDATE production_cycle SET cycle_status  = 'Finish List' WHERE cycle_id = ?", [$umid] );
        if($update_used_machine) header('Location:JobManagement.php?CTNId='. $CTNId .'&msg=Cycle Completed Successfully&class=success');
        else die('Something went wrong');

    }
    else die('Something went wrong');

    // else header('Location:TaskList.php?msg=Somthing Went Wrong&class=danger'); 