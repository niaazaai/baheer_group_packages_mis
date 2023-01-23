<?php
$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_POST['role_id']) && !empty($_POST['role_id']) && isset($_POST['permission_id']) && !empty($_POST['permission_id'])  ) {
    
    $role_id = $Controller->CleanInput($_POST['role_id']); 
    $permission_id = $Controller->CleanInput($_POST['permission_id']); 
    $title = $Controller->CleanInput($_POST['title']); 
    
    $IfExist = $Controller->QueryData("SELECT role_id , permission_id  FROM role_permission WHERE role_id=? AND permission_id=?  ",[ $role_id ,  $permission_id  ]);
    $RightExist = $IfExist->fetch_assoc(); 
    if($IfExist->num_rows > 0 ) header('Location:Permission.php?role_id='.$role_id .'&msg=Already assigned this permission&class=danger&title='.$title);
    else {
        $add_permission  = $Controller->QueryData("INSERT INTO role_permission (role_id , permission_id ) VALUES (? , ?)", [ $role_id , $permission_id ]);
        if($add_permission) {
            header('Location:Permission.php?role_id='.$role_id .'&title='.$title); 
        }
        else die('  <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">  <strong>!</strong> Something Went Wrong  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>'); 
    }
}
else
{
    die('<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <strong>!</strong> Something Went Wrong
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'); 
}
?>