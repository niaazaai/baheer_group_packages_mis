<?php
require_once 'Controller.php'; 

if(isset($_GET['name']) && !empty(trim($_GET['name'])) ) {
    $name = $Controller->CleanInput($_GET['name']);
    $Rows = $Controller->QueryData("SELECT EId , Ename FROM employeet WHERE Ename LIKE '%$name%' AND EDepartment = 'Production'", []);
    if($Rows->num_rows > 0 ){
        while ($DataRows = $Rows->fetch_assoc()) {
          $arr [] =  $DataRows; 
        }
        echo json_encode($arr);
      }
      else  echo json_encode('-1'); 

    // if($update_used_machine) header('Location:JobManagement.php?msg=Flute type for the cycle updated!&class=success&CTNId='.$CTNId);
    // else header('Location:JobManagement.php?msg=something went wrong!&class=danger&CTNId='.$CTNId);
    
} // END OF IF BLOCK 
else die('Somthing Went Wrong'); 

