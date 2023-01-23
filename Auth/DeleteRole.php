<?php
$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 


if(isset($_POST['Id']) && !empty($_POST['Id']))
{
    
    $Id = $Controller->CleanInput($_REQUEST['Id']); 

    $Delete = $Controller->QueryData("DELETE FROM role WHERE id = ?",[ $Id ]);
    
    var_dump($Delete); 
    if($Delete)
    {
        header("Location:ShowAccessList.php");
        // echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        // <strong>!</strong> Data Deleted Successfully.
        // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        // </div>';
    }
    else {
        header('Location:ShowAccessList.php');
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