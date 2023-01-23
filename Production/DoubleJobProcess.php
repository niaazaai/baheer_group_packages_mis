<?php
require_once 'Controller.php'; 

if(isset($_POST['umid']) && !empty($_POST['umid'])) {
    $CTN = $_POST['umid']; 
    $double_job_text =  substr(md5(rand()),0,10);
    
    if(count($CTN) != 2 ) {
        header('Location:TaskList.php?msg=You selected more than 2 jobs&class=danger');
    }

    foreach ($CTN as $key => $value) {
        
        $value = $Controller->CleanInput($value);
        preg_match_all('/\d+/', $value, $arr);
        $ctn_id = $arr[0][0]; 
        $umid = $arr[0][1]; 
        $Controller->QueryData("UPDATE used_machine SET status  = 'My_Job' , double_job = ?, double_job_carton_id=?   WHERE id = ?", [$double_job_text,$ctn_id,$umid] );

    }

    header('Location:TaskList.php');
}
else {
    header('Location:TaskList.php');
}

// var_dump($arr[0][1]);
// echo "<br>";
// var_dump($arr[0][0]);
// echo "<br>";