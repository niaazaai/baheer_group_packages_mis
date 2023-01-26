<?php 
    
    require_once 'Controller.php'; 

    if( isset($_POST['CaId']) && !empty($_POST['CaId']) && 
        isset($_POST['DesignCode']) && !empty($_POST['DesignCode']) && 
        isset($_POST['DesignBy']) && !empty($_POST['DesignBy']) && 
        isset($_POST['FinishTime']) && !empty($_POST['FinishTime'])) {

            
            $Query = "INSERT INTO `designinfo`( `DesignName1`, `DesignerName1`, `DesignStatus`, `DesignImage`, `CaId`, `Alarmdatetime`, `DesignCode1`, `CompleteTime`, `DesignStartTime`, `DesignDep`, `OriginalFile`, `design_type`) 
            VALUES (NULL,?,'Assigned',NULL,?,?,?,NULL,NULL,'Design',NULL,'Film')";
                
            $AssignFilm = $Controller->QueryData($Query ,  [$_POST['DesignBy'] , $_POST['CaId'] ,$_POST['FinishTime'], $_POST['DesignCode']  ]);  

            if($AssignFilm) {
                header('Location:Film.php?msg=Assigned to '. $_POST['DesignBy'] .' successfully &class=success'); 
            }



    }
    else header('Location:Film.php?msg=Post Not Complete&class=danger'); 