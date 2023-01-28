<?php 
    
    require_once 'Controller.php'; 
    if( isset($_POST['DesignId']) && !empty($_POST['DesignId']) && 
        isset($_POST['film_deadline']) && !empty($_POST['film_deadline']) && 
        isset($_POST['film_assigned_to']) && !empty($_POST['film_assigned_to'])   ) {

            $AssignFilm = $Controller->QueryData("UPDATE `designinfo` SET film_deadline = ?,  film_assigned_to = ?, film_status= 'Assigned' WHERE DesignId =?" ,
              [$_POST['film_deadline'] , $_POST['film_assigned_to'] ,$_POST['DesignId']]);  

            if($AssignFilm) {
                header('Location:Film.php?msg=Assigned to '. $_POST['film_assigned_to'] .' successfully &class=success'); 
            }
    }
    else header('Location:Film.php?msg=Post Not Complete&class=danger'); 