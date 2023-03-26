<?php
$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR.'App/Controller.php'; 
if(isset($_GET['CTNId'])&& !empty($_GET['CTNId'])) {

    $CTNId=$_GET['CTNId'];  
    $UpdateCarton = NULL; 
    if(isset($_GET['Status']) && !empty($_GET['Status']) && $_GET['Status'] == 'Archieve' ) {
        $UpdateCarton=$Controller->QueryData("UPDATE carton SET Track='Archieve' WHERE CTNId = ? ",[$CTNId]);
    }
    else {
        $UpdateCarton=$Controller->QueryData("UPDATE carton SET Track='Submitted' WHERE CTNId = ? ",[$CTNId]);
    }

    if($UpdateCarton)  header("Location:Polymer.php");
    else  header("Location:Polymer.php");
}
?>