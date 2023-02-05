<?php
$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_POST['Eid']) && !empty($_POST['Eid'])) {
    $Id = $Controller->CleanInput($_POST['Eid']); 
    $Disable = $Controller->QueryData("UPDATE employeet SET role_id=?  WHERE Eid = ? ",[ 0 , $Id ]);
    
    if($Disable)  header("Location:RoleList.php");
    else  header('Location:RoleList.php');
}
else die('<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">  <strong>!</strong> Something Went Wrong  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>   </div>'); 
 


?>