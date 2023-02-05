<?php
ob_start();
$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_POST['role_id']) && !empty($_POST['role_id']) && isset($_POST['permission_id']) && !empty($_POST['permission_id'])  ) {
    
    $role_id = $Controller->CleanInput($_POST['role_id']); 
    $permission_id = $Controller->CleanInput($_POST['permission_id']); 
    $title = $Controller->CleanInput($_POST['title']); 

    $IfExist = $Controller->QueryData("DELETE FROM role_permission WHERE  role_id=? AND permission_id=?",[ $role_id ,  $permission_id  ]);
    if($IfExist ) header("Location:Permission.php?role_id=$role_id&msg=Permission Removed successfully&class=success&title=$title");
    else die('<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">  <strong>!</strong> Something Went Wrong  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>'); 
    
}
else
{
    die('<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <strong>!</strong> Something Went Wrong
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'); 
}
?>