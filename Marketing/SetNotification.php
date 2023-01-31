<?php
    require_once 'Controller.php'; 
    require '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    if(isset($_GET["id"]) && !empty($_GET["id"])){

        $id = $Controller->CleanInput($_GET['id']); 
        $update = $Controller->QueryData("UPDATE alert SET status='0' WHERE id = ?",[$id]);

        if($update) echo json_encode([$id]);
        else echo json_encode('-1'); 
        
    }//end of first if 
 
?>
