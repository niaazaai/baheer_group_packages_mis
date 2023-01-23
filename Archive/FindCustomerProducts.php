<?php

$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_GET["query"]) && !empty($_GET["query"]) ){
    $query = $Controller->CleanInput($_GET['query']);

    $Join = ''; 
    $Field = ''; 
    if(isset($_GET["polymer"]) && !empty($_GET["polymer"]) ){
        $polymer = $Controller->CleanInput($_GET['polymer']);
        $Join = 'LEFT JOIN designinfo ON designinfo.CaId = carton.CTNId'; 
        $Field = ', DesignCode1 , CTNColor'; 
    }
    
    $DataRows = $Controller->QueryData("SELECT CTNId , ProductName  , CONCAT( CTNLength , ' x ', CTNWidth , ' x ' , CTNHeight ) AS Size $Field  FROM carton $Join WHERE CustId1  = ?  LIMIT 10" , [$query]);
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







