<?php

$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_GET["query"]) && !empty($_GET["query"]) ){
    
    $query = $Controller->CleanInput($_GET['query']);
    $DataRows = $Controller->QueryData("SELECT CustId , CustName FROM ppcustomer WHERE CustName  LIKE LOWER('%$query%')  LIMIT 10" , []);
    if($DataRows->num_rows > 0 ){
      while ($Customer = $DataRows->fetch_assoc()) {
        $arr [] =  $Customer; 
      }
      echo json_encode($arr);
    }
    else  echo json_encode('-1'); 

}//end of first if 
else  echo json_encode('-1'); 

?>







