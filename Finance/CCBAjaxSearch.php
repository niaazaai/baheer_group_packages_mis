<?php

$ROOT_DIR = 'F:/BaheerApps/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_GET["query"]) && !empty($_GET["query"]) ){
    $query = $Controller->CleanInput($_GET['query']);

    $DataRows = $Controller->QueryData("  SELECT distinct CompId, CustName FROM cartonproduction 
    INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
    WHERE CustName LIKE LOWER('%$query%')  AND ProStatus='Accept' and ProQty-ProOutQty > 0  " , []);

     
  

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







