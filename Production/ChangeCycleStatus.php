<?php
require_once 'Controller.php'; 

if(isset($_REQUEST['cycle_id']) && !empty(trim($_REQUEST['cycle_id'])) ) {
    $cycle_id = $Controller->CleanInput($_REQUEST['cycle_id']);
    $date = date('Y-m-d H:i:s'); 
    $update_used_machine = $Controller->QueryData(
        "UPDATE production_cycle SET cycle_status  = 'Task List' , page_arrival_time = ?  WHERE cycle_id = ?", 
        [$date,$cycle_id] );
    if($update_used_machine) header('Location:TaskList.php');
    else die('Something went wrong'); 
}


// UMID means used_machine table primary key ( id ) this block will transfter the selected machine from task list to myjob 
if( isset($_GET['umid']) && !empty(trim($_GET['umid'])) && isset($_GET['ccs']) && !empty(trim($_GET['ccs']))  ) {
    if($_GET['ccs'] == '1qaz2wsx3edc4rfv5tgb6yhn') { // ccs field enable us to only execute this block of code and avoid executing other blocks 
        
        $umid = $Controller->CleanInput($_GET['umid']);
        $CTNId = $Controller->CleanInput($_GET['CTNId']);

        $update_used_machine = $Controller->QueryData("UPDATE used_machine SET status  = 'My_Job' WHERE id = ?", [$umid] );

        // this line is used to change the status of track to request to show polymer department for requesting polymer automaltilly 
        $Controller->QueryData("UPDATE carton SET Track = 'Request' WHERE CTNId = ?", [$CTNId]); 
        // var_dump($Controller);
        // echo "------------------"; 
        // die(); 

        if($update_used_machine) header('Location:TaskList.php?msg=Job Sent Successfully$class=success');
        else die('Something went wrong');
    }
}





 