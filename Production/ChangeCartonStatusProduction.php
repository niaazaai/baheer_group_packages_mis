<?php
require_once 'Controller.php'; 

if(isset($_REQUEST['CTNId']) && !empty(trim($_REQUEST['CTNId']))  && isset($_REQUEST['Production']) && !empty(trim($_REQUEST['Production']))   ) {

    $CTNId = $Controller->CleanInput($_REQUEST['CTNId']);

    $status = ''; 
    $redirect_to = ''; 
    
    if($_REQUEST['Production'] == 'Continue')   $status = 'Production'; 
    else if($_REQUEST['Production'] == 'Urgent')  $status = 'Urgent'; 
    else if($_REQUEST['Production'] == 'Task List')  $status = 'Task List';

    if(isset($_REQUEST['Redirect']) && !empty(isset($_REQUEST['Redirect'])) ){
        $redirect_to = $_REQUEST['Redirect']; 
    }
    
    if($redirect_to == '') {
        die('Do not know where to redirect'); 
    }
 
    $update_used_machine = $Controller->QueryData("UPDATE carton SET CTNStatus  = '". $status ."'  WHERE CTNId = ?", [   $CTNId  ] );
   
    if($update_used_machine) header('Location:'. $redirect_to .'.php');
    else header('Location:index.php?msg=something went wrong!&class=danger');
    
    
}

