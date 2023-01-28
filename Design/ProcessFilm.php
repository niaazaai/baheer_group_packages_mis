<?php 
    require_once 'Controller.php'; 
    if(isset($_POST['DesignId']) && !empty($_POST['DesignId'])) {
        $DesignId = $Controller->CleanInput($_POST['DesignId']); 
        $UPDATE=$Controller->QueryData("UPDATE designinfo set film_status = 'Proccess' , film_start_date = CURRENT_TIMESTAMP WHERE DesignId = ? ",[$DesignId]);
        if($UPDATE) {
            header('Location:Film.php?msg=Film is under process &class=success'); 
        }
        else header('Location:Film.php?msg=Something went wrong&class=danger'); 
    }
    else header('Location:Film.php?msg=Post Not Complete&class=danger'); 

 