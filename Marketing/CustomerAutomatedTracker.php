<?php 

require_once 'Controller.php';  

$DataRows = $Controller->QueryData("SELECT carton.CTNOrderDate , carton.JobNo , carton.ProductName , carton.CTNStatus ,carton.CTNFinishDate, ppcustomer.CustName , ppcustomer.CusStatus , ppcustomer.PPCondition , ppcustomer.Timelimit
FROM carton inner JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  WHERE carton.CTNStatus='Order' AND JobNo != 'NULL' " , []);


// var_dump($DataRows);
if($DataRows->num_rows > 0 ){
    while ($Customer = $DataRows->fetch_assoc()) {
        if($Customer['CusStatus'] != 'Active' && $Customer['PPCondition'] != 'Working' ) {
            $Customer = $Controller->QueryData("UPDATE ppcustomer SET CusStatus = ? , PPCondition=?   " , [ 'Active' , 'Working']);
        }

    } 
}



// $DataRows = $Controller->QueryData("SELECT ppcustomer.CustId , ppcustomer.Timelimit FROM carton 
// INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE JobNo != 'NULL' GROUP BY ppcustomer.CustId;" , []);

// $HasRunningJob = false; 

// if($DataRows->num_rows > 0 ){
//     while ($Customer = $DataRows->fetch_assoc()) {
//         $mostRecent= 0;
//         $now = time();

//         // echo $Customer['CustId'];
//         // echo "<br>";
//         // echo "----------------------";
//         // carton.CTNOrderDate , carton.JobNo , carton.ProductName , ppcustomer.CustName , 

//         $SingleCustomer = $Controller->QueryData("SELECT  ppcustomer.CustId , carton.CTNFinishDate, ppcustomer.CusStatus  , carton.CTNStatus 
//         FROM carton inner JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  WHERE ppcustomer.CustId= ? AND JobNo != 'NULL' ", [$Customer['CustId']]);
//         while ($Rows = $SingleCustomer->fetch_assoc()) {
//             if($Rows['CTNStatus'] != 'Completed' && $Rows['CTNStatus'] != 'Cancel'){
//                 $HasRunningJob = true; 
//             }
//             $curDate =  date('Y-m-d', strtotime($Rows['CTNFinishDate']) ); 
//             if ($curDate > $mostRecent  ) {
//                 $mostRecent = $curDate;
//             }
//         }// end of while 

//         $month = (int) filter_var($Customer['Timelimit'], FILTER_SANITIZE_NUMBER_INT);  
//         $newDate = date('Y-m-d', strtotime($mostRecent. ' + '. $month .' months')); 

//         if($HasRunningJob) {
//             if($newDate <= date('Y-m-d')){
              
//                 $UpdatePPCustomerStatus = $Controller->QueryData("UPDATE ppcustomer SET CusStatus = ? , PPCondition=?   " , [ 'Pending' , 'Timelimit']);
//                 if($UpdatePPCustomerStatus) {
//                     echo "--------- done ------------";  
//                     echo "<br>";       
//                 }
//                 else {
//                     echo '---------- still has time must show notification --------------'; 
//                     echo "<br>";     
//                 }
            
//             }
//         }
        
//     }
    
// }


// var_dump($Customer);
// echo "<br>"; 
// echo "<br>"; 
// check if customer order anything (check if status order and jobNo is not null )
//     if yes then   [
//         change customer status to active and condition to working 
// else do nothing 


// echo "<br>";
        // echo "<========================>";
        // echo "<br>"; echo "<br>";
        // echo $mostRecent ;
        // echo "<br>";
        // echo $Customer['Timelimit']; 
        // echo "<br>";
       
        // echo   $month; 
        // echo "<br>";
        // $date = "2021-11-01";
        // echo "**********************";
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";


        // when we store customer the status should be automatically prospect and condition should be new 
        // case 2 : 
        // if the customer do not order anything do nothing 
        // if the customer orders carton and gets jobNo then the customer status must change to active and condition must be working 
        
        // if the customer order carton 
        //     if he/she has no order running  and all orders of customer is complete the based on latest order completion date 
        //     and sum the time limit  if the time deadline is exceeded the the customer status must be pending  condition timelimit  
        // check if customer order anything (check if status order and jobNo is not null )
        //     if yes then   [
        //         change customer status to active and condition to working 
        // else do nothing 
        // if customer has no running order 
        
        

        

?>