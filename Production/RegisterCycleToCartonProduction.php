<?php

    session_start(); 
    ob_start(); 
    require_once 'Controller.php'; 

    if(isset($_REQUEST['JobNo']) && !empty(trim($_REQUEST['JobNo'])) && 
    isset($_REQUEST['CTNId']) &&  !empty(trim($_REQUEST['CTNId'])) && 
    isset($_REQUEST['CustId']) &&  !empty(trim($_REQUEST['CustId'])) && 
    isset($_REQUEST['CYCLE_ID']) &&  !empty(trim($_REQUEST['CYCLE_ID']))  ) { 
 
        // this for sanitizing user input 
        foreach ($_REQUEST as $key => $value) {
            $_REQUEST[$key] = $Controller->CleanInput($value); 
        }

        // ProDate , ProSubmitDate , ProSize , ProOutQty `ProSize`, `ProOutQty`, 
        $DataRows=$Controller->QueryData("INSERT INTO cartonproduction  (
        cycle_id , `CtnId1` , `ProSubmitBy`, `CompId`, 
        `ProQty`, `ProBrach`, `ProStatus`, `Plate`,
        `Line`,`Pack`,`ExtraPack`,`Carton`,`ExtraCarton`)
        VALUES ( 
        ? , ? , ? , ? , 
        ? , ? , ? , ? , 
        ? , ? , ? , ?,? )",

        [$_REQUEST['CYCLE_ID'] , $_REQUEST['CTNId'] , $_SESSION['EId'] , $_REQUEST['CustId'] , 
         $_REQUEST['Total'] ,$_REQUEST['Unit'] ,'Pending' ,  $_REQUEST['Plate'] , 
         $_REQUEST['Line'] , $_REQUEST['Pack'] , $_REQUEST['ExtraPack'] ,  $_REQUEST['Carton']  , $_REQUEST['ExtraCarton']  ] );



        if($DataRows) {
            // $pro_cycle = $Controller->QueryData("SELECT * FROM production_cycle WHERE cycle_id = ? ",[$_REQUEST['CYCLE_ID']  ]);
            $pro_cycle = $Controller->QueryData("UPDATE production_cycle SET cycle_status = 'Completed' , cycle_produce_qty = ? 
            WHERE cycle_id = ? ",[ $_REQUEST['Total'] , $_REQUEST['CYCLE_ID'] ]);

            // this block will get the carton produced qty and update it with new value. 
            $Produced_QTY =  $Controller->QueryData("SELECT ProductQTY , CTNId  FROM carton WHERE CTNId = ? ",[$_REQUEST['CTNId']  ]);

            $PQTY = $Produced_QTY->fetch_assoc()['ProductQTY'] ;  
            $PQTY += $_REQUEST['Total'];

            $Update_produced = $Controller->QueryData("UPDATE carton SET ProductQTY = ? WHERE CTNId = ? ",[ $PQTY , $_REQUEST['CTNId'] ]);
            if($Update_produced && $pro_cycle && $Produced_QTY) header('Location:FinishList.php?msg=Data Saved Successfully&class=success'); 
            
        }
    }
    else header("Location:FinishList.php?msg=Somthing Went Wrong");
?>