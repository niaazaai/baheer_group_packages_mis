<?php 
    require_once 'Controller.php' ; 
    if(isset($_POST['CYCLE_ID']) && trim(!empty($_POST['CYCLE_ID']))   ) {
        $Notokay = false; 
        
        // first we have to delete previous record of selection to replace for the new selection 
        if($Controller->QueryData('DELETE FROM used_machine WHERE cycle_id =? AND status = "Incomplete" ', [$_POST['CYCLE_ID']])) {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'machine_') !== false) {
                    $Check  =  $Controller->QueryData('SELECT * FROM used_machine WHERE cycle_id = ? AND  machine_id = ?', [$_POST['CYCLE_ID'] , $value ]); 
                    if($Check->num_rows ==  0 ) { 
                        // insert into database which machine is choosed in which cycle. 
                        $create_cycle  = $Controller->QueryData('INSERT INTO used_machine SET cycle_id = ? , machine_id = ? , status = ?' , [$_POST['CYCLE_ID'] , $value , 'Incomplete' ]);
                        if(!$create_cycle) $Notokay = true; 
                    }
                }
            }
        } 

        if(isset($_POST['HasManual']) && trim(!empty($_POST['HasManual']))){
            if($_POST['HasManual'] == 'Manual') {
                 //update has_manual value for manual section to show 
                 if(!$Controller->QueryData('UPDATE production_cycle SET has_manual = ? WHERE cycle_id =? ' ,  [ 'Yes' , $_POST['CYCLE_ID'] ])) 
                 echo "Error:Manual Field Not Updated!";
            }
            else die('Error: You have changed the Manual value') ; 
        }
        
        $CTNId = $_POST['CTNId']; 
        $Manual = 'Location:JobManagement.php?CTNId='.$_POST['CTNId']; 
        if(isset($_POST['Manual']) && trim(!empty($_POST['Manual'] ) )){
            $Manual = 'Location:ManualCycle.php';  
        }
        
        if($Notokay) die("Data was not saved in the system!"); 
        else header($Manual ); 
    }
    // else header("Location:Cycle.php?CTNId=".$_POST['CTNId']); 
?>