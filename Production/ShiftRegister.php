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
        var_dump($_REQUEST); 
        // echo "Update";
    }
    else {
        // echo "insert new ";
        $Controller->QueryData('INSERT INTO machine_shift_history 
        WHERE CTNId = ? AND cycle_id = ? AND machine_id = ? AND EId = ?',
        [$_REQUEST['CTNId'] ,$_REQUEST['cycle_id'] ,$_REQUEST['machine_id'] , $_REQUEST['EId'] ]);
    }




}



?>