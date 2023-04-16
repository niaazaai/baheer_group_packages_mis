<?php

$ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
require_once $ROOT_DIR. 'App/Controller.php'; 

if(isset($_GET["query"]) && !empty($_GET["query"]) ){
    
    $query = $Controller->CleanInput($_GET['query']);
     
    if($_GET['query'] == 'Production') { 
      $DataRows = $Controller->QueryData("SELECT  `ProDate`,  SUM(`ProQty`) AS Produced_Qty, `ProBrach` 
      FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
      INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
      where ProStatus='Accept' and ProBrach='Production' and ProDate > DATE_SUB(NOW(), INTERVAL 1 WEEK) group by  ProDate order by ProDate" , []);
    }
    elseif($_GET['query'] == 'Manual') { 
        $DataRows = $Controller->QueryData("SELECT  `ProDate`,  SUM(`ProQty`) AS Produced_Qty, `ProBrach` 
        FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
        INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
        where ProStatus='Accept' and ProBrach='Manual' and ProDate > DATE_SUB(NOW(), INTERVAL 1 WEEK) group by  ProDate order by ProDate " , []);

    }

    
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







