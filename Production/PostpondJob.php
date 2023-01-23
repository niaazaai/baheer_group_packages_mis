<?php 

require_once 'Controller.php'; 

if(isset($_REQUEST['CTNId']) && !empty(trim($_REQUEST['CTNId']))) {

 
    $_REQUEST['CTNId'] = $Controller->CleanInput($_REQUEST['CTNId']); 
    $_REQUEST['ProductionPostpondComment'] = $Controller->CleanInput($_REQUEST['ProductionPostpondComment']); 
    $_REQUEST['ProductionPostponedDate'] = $Controller->CleanInput($_REQUEST['ProductionPostponedDate']); 

    $Postpond = $Controller->QueryData(
    'UPDATE carton SET ProductionPostpondComment =? , ProductionPostponedDate=?  , CTNStatus=? WHERE CTNId = ?' ,
    [
        $_REQUEST['ProductionPostpondComment'] , 
        $_REQUEST['ProductionPostponedDate'] , 
        'Production Pending' , 
        $_REQUEST['CTNId']
    ]); 
    
    if($Postpond) {
        header('Location:JobManagement.php?msg=Job Postponded&class=success&CTNId='. $_REQUEST['CTNId']); 
    }
    else {
        header('Location:JobManagement.php?msg=something went wrong&class=danger&CTNId='. $_REQUEST['CTNId']); 
    }

}// end of first if block 
else header('JobCenter.php')
?>
