<?php
    require_once 'Controller.php'; 
    require '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    $DataRows = $Controller->QueryData("SELECT * FROM alert WHERE department = 'Finance' AND user_id = '108' AND status = 1 " , []);
    if($DataRows->num_rows > 0 ){
      while ($Customer = $DataRows->fetch_assoc()) {
          $Customer['created_at'] = Carbon::create( Carbon::parse($Customer['created_at'])->format('Y-m-d H:i:s')  , 'Asia/Kabul')->diffForHumans(); 
          $arr [] =  $Customer; 
      } 
      echo json_encode($arr);
    }
    else  echo json_encode('-1'); 

    // if(isset($_GET["query"]) && !empty($_GET["query"]) ){
        
    //     $query = $Controller->CleanInput($_GET['query']);
    //     $DataRows = $Controller->QueryData("SELECT CustId , CustName FROM ppcustomer WHERE CustName  LIKE LOWER('%$query%')  LIMIT 10" , []);
    //     if($DataRows->num_rows > 0 ){
    //     while ($Customer = $DataRows->fetch_assoc()) {
    //         $arr [] =  $Customer; 
    //     }
    //     echo json_encode($arr);
    //     }
    //     else  echo json_encode('-1'); 

    // }//end of first if 
    // else  echo json_encode('-1'); 
 
       
?>







