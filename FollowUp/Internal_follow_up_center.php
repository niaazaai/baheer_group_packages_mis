<?php require_once '../App/partials/Header.inc';  ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc';
date_default_timezone_set('Asia/Kabul');
 

// job arrived at finance department , track when the job arrived there if arrival time + deadline is greater then current time. 

    $Query = "SELECT CTNId , CustName , JobNo , CTNOrderDate , CTNFinishDate , ProductName  , CTNQTY   , CusProvince   , CTNStatus  , job_arrival_time
        FROM carton
        INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
        WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond'   ";
    $DataRows = $Controller->QueryData($Query, []); 




    $Internal = []; 
$IFS = $Controller->QueryData('SELECT * FROM internal_followup_setting', []); 

while($fs = $IFS->fetch_assoc()) {
   array_push( $Internal , $fs); 

}

echo "<pre>"; 
var_dump($Internal); 
echo "</pre>"; 

// echo $DataRows->fetch_assoc()['job_arrival_time']; 
// echo "<br>";


    $day = 0; 
    $hr  = 0; 
    $min = 48; 
    $arrival_time = $DataRows->fetch_assoc()['job_arrival_time'] ; 

    // $arrival_time = '2023-02-22 15:00:00';
    // $hours = "+$day days $hr hours $min minutes";
    
    // $d0 = strtotime(date('Y-m-d 00:00:00'));
    // $d1 = strtotime(date('Y-m-d').$hours);

    // $sumTime = strtotime($arrival_time) + ($d1 - $d0);
    // $deadline = date("Y-m-d H:i:s", $sumTime);
    // echo $deadline; 
    // echo "<br>";
    // echo date("Y-m-d H:i:s"); 

    // if(date("Y-m-d H:i:s") > $deadline) {
    //     echo "<br>";
    //     echo "alert user"; 
    // }


    function CheckJobTimouts($arrival_time , $day , $hr , $min ) {
 
        $hours = "+$day days $hr hours $min minutes";

        $d0 = strtotime(date('Y-m-d 00:00:00'));
        $d1 = strtotime(date('Y-m-d').$hours);

        $sumTime = strtotime($arrival_time) + ($d1 - $d0);
        $deadline = date("Y-m-d H:i:s", $sumTime);

        if(date("Y-m-d H:i:s") > $deadline) return true; 
        else return false; 
    } // END OF check job timouts 
    
    var_dump(CheckJobTimouts($arrival_time , $day , $hr , $min))
?>  
 



<?php if(isset($_GET['msg']) && !empty($_GET['msg']))  {
          echo' <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                  <strong>Attention: </strong>'. $_GET['msg'] .' 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
      }  
?>
    <div class="m-3">
    <div class="card " style = "background-color:# ;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0">Internal Follow Up Center</h3>
        </div>
    </div>
    </div>


    <div class="m-3">
    <div class="card " style = "background-color:# ;" >
      <div class="card-body d-flex justify-content-between shadow">
    <table class="table table-bordered border-dark m-0 " >
            <thead>
                <tr class = "fw-bold" >
                    <td >#</td>
                    <td>Quote</td>
                    <td>JobNo</td>
                    <td>Customer</td>
                    <td>Product</td>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1 ;  while ($Data = $DataRows->fetch_assoc()) {  ?>
                <tr>
                    <td><?= $counter++; ?></td>
                    <td><?=$Data['CTNId']?></td>
                    <td><?=$Data['JobNo']?></td>
                    <td><?=$Data['CustName']?></td>
                    <td><?=$Data['ProductName']?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
<?php  require_once '../App/partials/Footer.inc'; ?>
