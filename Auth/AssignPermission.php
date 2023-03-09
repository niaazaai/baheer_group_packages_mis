<?php
$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_POST['role_id']) && !empty($_POST['role_id']) && isset($_POST['permission_id']) && !empty($_POST['permission_id'])  ) {
    


    $role_id = $Controller->CleanInput($_POST['role_id']); 
    $title = $Controller->CleanInput($_POST['title']); 
    // $module = $Controller->CleanInput($_POST['module']); 
    // echo $module; 
$query_status = true; 
    foreach ($_POST['permission_id'] as $permission_id) {
        $permission_id = $Controller->CleanInput($permission_id); 

        $IfExist = $Controller->QueryData("SELECT role_id , permission_id  FROM role_permission WHERE role_id=? AND permission_id=?  ",[ $role_id ,  $permission_id  ]);
        $RightExist = $IfExist->fetch_assoc(); 
        if($IfExist->num_rows > 0 ) {
            // basically do nothing 
            //header('Location:Permission.php?role_id='.$role_id .'&msg=Already assigned this permission&class=danger&title='.$title);
        } 
        else {
            $add_permission  = $Controller->QueryData("INSERT INTO role_permission (role_id , permission_id ) VALUES (? , ?)", [ $role_id , $permission_id ]);
            if(!$add_permission)  $query_status = false;
             
        }
    } // end of foreach 

    if($query_status)  header('Location:Permission.php?role_id='.$role_id .'&title='.$title); 
    else die('<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">  <strong>!</strong> Something Went Wrong  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>');

//  echo "<pre>"; 
//     var_dump($_POST);
//     echo "<pre>";  
//     die(); 

   
}
else
{
    die('<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <strong>!</strong> Something Went Wrong
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>'); 
}
?>