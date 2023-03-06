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


    // THIS BLOCK OF CODE IS USED WHEN THE OPERATOR WANTS TO END THE JOB AND SHIFT AT THE SAME TIME 
    if(isset($_REQUEST['last_shift']) && !empty($_REQUEST['last_shift'])) {
        if($_REQUEST['last_shift'] == 'LAST_SHIFT') {


            // CHECK IF WE ALREADY HAVE THE RECORD OR NOT 
            $Row = $Controller->QueryData('SELECT * FROM machine_shift_history 
            WHERE CTNId = ? AND cycle_id = ? AND machine_id = ? AND EId = ?',
            [$_REQUEST['CTNId'][0] ,$_REQUEST['cycle_id'][0] ,$_REQUEST['machine_id'] , $_REQUEST['shift_eid'] ]);
            
            if($Row->num_rows > 0 ) {
                echo "Do Nothing !";  // WE DON'T NEED TO REDIRECT BECAUSE WE NEED DO OTHER OPERATION 
                // header("Location:JobProcess.php?msg=Shift already exist&class=danger&CTNId=" .$_REQUEST['CTNId'] ."&CYCLE_ID=" .$_REQUEST['cycle_id'] ."&machine_id=" .$_REQUEST['machine_id'] ."&double_job=" . $double_job ); 
            }
            else {
                $con = $Controller->QueryData('INSERT INTO 
                machine_shift_history (`CTNId`, `cycle_id`, `machine_id`, `EId`, `produced_qty`, `wast`, `labor`, `start_date`, `end_date` )
                VALUES (?,?,?,?,?,?,?,?,?)',
                [
                    $_REQUEST['CTNId'][0]  ,
                    $_REQUEST['cycle_id'][0] ,
                    $_REQUEST['machine_id'] , 
                    $_REQUEST['shift_eid'] , 
                    $_REQUEST['shift_produced_qty'] ,
                    $_REQUEST['shift_wast_qty'] ,
                    $_REQUEST['shift_labor'] , 
                    date("Y-m-d H:i:s") , // ABOUT DATE PLEASE TAKE THE CLOCK IN OF ATTENDANCE FOR START OF SHIFT ( start_date )
                    date("Y-m-d H:i:s")   
                ]);
            }

        } // end of LAST_SHIFT 
    }// end of last shift isset and empty block 
    
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
        header('Location:JobProcess.php?CTNId='. $_REQUEST['CTNId'][0] .'&CYCLE_ID='.$_REQUEST['cycle_id'][0] . '&machine_id=' . $machine_id .'&double_job='.$double_job   );
        // header('Location:JobUnderProcess.php');
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