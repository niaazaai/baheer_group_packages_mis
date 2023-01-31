<?php
    require_once 'Controller.php'; 
    require '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    if( isset($_GET["department"]) && !empty($_GET["department"]) &&  isset($_GET["user_id"]) && !empty($_GET["user_id"]) ){
        $department = $Controller->CleanInput($_GET['department']); 
        $user_id = $Controller->CleanInput($_GET['user_id']); 
        $DataRows = $Controller->QueryData("SELECT * FROM alert WHERE department = ? AND user_id = ? AND status = 1 ORDER BY created_at DESC  LIMIT 15" , [ $department , $user_id  ]);
        if($DataRows->num_rows > 0 ){
          while ($Customer = $DataRows->fetch_assoc()) {
              $Customer['last_time'] = $Customer['created_at']; 
              $Customer['created_at'] = Carbon::create( Carbon::parse($Customer['created_at'])->format('Y-m-d H:i:s')  , 'Asia/Kabul')->diffForHumans(); 
              $arr [] =  $Customer; 
          }
          echo json_encode($arr);
        }
        else  echo json_encode('-1');
    }//end of first if 
    else  echo json_encode('-1'); 
?>