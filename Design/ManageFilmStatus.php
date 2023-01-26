<?php 
    
    require_once 'Controller.php'; 

    if(isset($_POST['DesignId']) && !empty($_POST['DesignId'])) {
        $DesignId = $Controller->CleanInput($_POST['DesignId']); 
            
        $UPDATE=$Controller->QueryData("UPDATE designinfo set DesignStatus = 'Proccess' , DesignStartTime = CURRENT_TIMESTAMP WHERE DesignId = ? ",[$DesignId]);
        if($UPDATE) {
            header('Location:Film.php?msg=Film is Processing &class=success'); 
        }
    }
    else header('Location:Film.php?msg=Post Not Complete&class=danger'); 