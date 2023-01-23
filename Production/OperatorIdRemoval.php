
<?php
 
  require_once 'Controller.php'; 
  if(isset($_GET['machine_opreator_id']) && !empty($_GET['machine_opreator_id']))
  {
    $machine_opreator_id=$_GET['machine_opreator_id']; 
     echo $machine_opreator_id;
     $update=$Controller->QueryData("UPDATE machine SET machine_opreator_id=? WHERE machine_opreator_id=? ",[NULL,$machine_opreator_id]);
      if($update){ header("Location:EmployeeList.php"); }
  }
  else die('Somthing Went Wrong'); 
?>