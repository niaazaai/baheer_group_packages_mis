<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';

    if( isset($_POST['from']) && !empty($_POST['from']) && isset($_POST['to']) && !empty($_POST['to']) && isset($_POST['machine']) && !empty($_POST['machine']) ) {
 
        $from_date = $Controller->CleanInput($_POST['from']);
        $to_date = $Controller->CleanInput($_POST['to']);
        $machine = $Controller->CleanInput($_POST['machine']);

        // echo "<kbd>"; 
        // var_dump($_POST); 
        // echo "</kbd>"; 


        // find that the flex between a and b date how much it produced , how much time did it took in each time
        // which jobs does the flexo runs 
        $DataRows = $Controller->QueryData(' SELECT 
        carton.CTNId ,carton.JobNo , carton.ProductName , carton.CTNQTY , carton.CTNUnit, CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) , " x " , FORMAT ( carton.CTNWidth / 10 , 1 ) , " x ", FORMAT(carton.CTNHeight/ 10,1) ) AS Size , 
        used_machine.produced_qty , used_machine.wast_qty , used_machine.number_labor , used_machine.start_time , used_machine.end_time , used_machine.machine_id as machine_id , used_machine.cycle_id as cycle_id ,
        machine.machine_name  
         FROM used_machine 
            INNER JOIN machine ON machine.machine_id = used_machine.machine_id 
            INNER JOIN production_cycle ON used_machine.cycle_id = production_cycle.cycle_id 
            INNER JOIN carton ON carton.CTNId = production_cycle.CTNId
        WHERE  used_machine.machine_id = ? AND DATE_FORMAT(end_time, "%Y-%m-%d")  BETWEEN ? AND ? AND used_machine.status = "Complete"', 
        [ $machine , $from_date , $to_date ]);
        
        // /AND production_cycle.cycle_status = 'Completed' 
        
        // echo "<br>"; 
        // while($Rows = $DataRows->fetch_assoc()) {
        
        //     // var_dump($Rows); 

        //     // $DataRows1 = $Controller->QueryData("SELECT carton.CTNId  , carton.JobNo, carton.ProductName , carton.ProductQTY, carton.CTNQTY FROM carton  WHERE  CTNId = ? ",  [$Rows['CTNId']])->fetch_assoc();
        //     // echo  $DataRows1['JobNo'] . ' - ' . $DataRows1['ProductName'] . ' - ' . $DataRows1['ProductQTY'] . ' - ' . $DataRows1['CTNQTY']; 

        //     // echo $Rows['CTNId']; 
        //     echo ' - '; 
        //     echo $Rows['machine_name']; echo '--> ';  
        //     echo $Rows['produced_qty']; echo '-- ';  
        //     echo $Rows['wast_qty']; echo '-- ';  
        //     echo $Rows['ProductName'] . ' ( ' . $Rows['Size'] . ' ) ' . $Rows['CTNUnit']; echo '-- ';  
        //     echo $Rows['JobNo'];echo '-- '; 
        //     echo $Rows['number_labor'];
        //     echo "<br>"; 

        //     // $start_time = new DateTime($Rows['start_time']);
        //     // $end_time = new DateTime($Rows['end_time']);
        //     // $diff = $start_time->diff($end_time);
        //     // $total_time =  $diff->format('%H:%I:%S');  

        //     // echo ' - ' . $total_time ; 
        //     // echo "<br>"; 


        // }







        // if($machine == 'ALL') $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE PrBranch = 'Manual' AND PrDate BETWEEN ? AND ?",   [ $from_date , $to_date]);  
        // else $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE  TRIM(MachineName) = TRIM(?) AND  PrBranch = 'Manual' AND PrDate BETWEEN ? AND ?", [$machine,$from_date,$to_date]);
    }
    else {

        $DataRows = $Controller->QueryData('SELECT 
         carton.CTNId , carton.JobNo , carton.ProductName , carton.CTNQTY , carton.CTNUnit, CONCAT( FORMAT(carton.CTNLength / 10 ,1 ) , " x " , FORMAT ( carton.CTNWidth / 10 , 1 ) , " x ", FORMAT(carton.CTNHeight/ 10,1) ) AS Size , 
        used_machine.produced_qty , used_machine.wast_qty , 
        used_machine.number_labor , used_machine.start_time , used_machine.end_time , 
        used_machine.machine_id as machine_id , used_machine.cycle_id as cycle_id ,
        machine.machine_name  
        FROM used_machine 
            INNER JOIN machine ON machine.machine_id = used_machine.machine_id 
            INNER JOIN production_cycle ON used_machine.cycle_id = production_cycle.cycle_id 
            INNER JOIN carton ON carton.CTNId = production_cycle.CTNId
        WHERE  used_machine.machine_id = 1 AND used_machine.status = "Complete"', []);

        // $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE YEARWEEK(PrDate, 1) = YEARWEEK(CURDATE(), 1) ",  []);
    }
?>

<div class=" m-3">
    <div class="card " >
      <div class="card-body d-flex justify-content-between align-item-center shadow">
            <h3 class="m-0 p-0"> 
                <a class="btn btn-outline-primary   me-1" href="Reports.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg>
                </a>
              Time Track Report By Machine  
            </h3>
            <div class= "mt-1">
                <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px; text-decoration:none;"  title="Click to Read the User Guide ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                    </svg>
                </a>
                <a class="btn btn-outline-danger " data-bs-toggle="collapse" href="#colapse1" role="button" aria-expanded="false"  > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg> Search   
                </a>
            </div>
        </div>
    </div>
</div>

<div class="collapse shadow" style="position: absolute; z-index: 1000; width: 87%; left: 0%; margin-top:-21px; " id="colapse1">
    <div class="card card-body border shadow">
      <form action="" method="post">
        <div class="row">
           
            <div class="col-lg-3 col-sm-12 col-md-4">
                <div class="form-floating  mt-2">
                    <select class="form-select" id="floatingSelect" name  = "machine" aria-label="Floating label select example">
                        <option value = "ALL" selected>ALL</option>
                        <?php $ma = $Controller->QueryData('SELECT machine_id , machine_name , machine_type FROM machine WHERE machine_type = "Production" '); while($machine=$ma->fetch_assoc()): ?>
                            <option value="<?=$machine['machine_id']?>"><?=$machine['machine_name']?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="floatingSelect">Machines</label>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-4">
                <div class="form-floating  mt-2">
                    <input type="date" name = "from" class="form-control"  id = " " placeholder="  " >
                    <label for="Reel"> From Date  </label>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-md-4">
                <div class="form-floating  mt-2">
                    <input type="date" name = "to" class="form-control" placeholder="  " >
                    <label for="Reel"> To Date  </label>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12 col-md-2">
                <div class="d-grid gap-2 mt-2">
                <button type="submit" class="btn btn-primary">Find</button>
                </div>
            </div>

        </div>
      </form>
    </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body pt-2">
        <table class= "table " >
            <thead>
                <tr class="table-info">
                    <th></th>
                    <th> JobNo </th>
                    <th> Description </th>
                    <th> Produced QTY </th>
                    <th> Wast QTY </th>
                    <th> Labor </th>
                    <th> Start </th>
                    <th> End </th>
                    <th>Total Time Taken</th>
                    <th>Actual TIme Taken </th>
                    <th>Down Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if($DataRows->num_rows > 0 ) {   while($Rows = $DataRows->fetch_assoc()): ?>
                        <tr>  
                            <td>
                                <a href = "#"onclick = "view_details(`details_tr_<?=$Rows['CTNId']?>`)" class = "btn " >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle p-0 m-0" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg> 
                                </a>
                            </td>
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['ProductName'] . ' ( ' . $Rows['Size'] . ' ) ' . $Rows['CTNUnit']; ?></td>
                            <td><?=$Rows['produced_qty']?></td>
                            <td><?=$Rows['wast_qty']?></td>
                            <td><?=$Rows['number_labor']?></td>
                            <td><?=$Rows['start_time']?></td>
                            <td><?=$Rows['end_time']?></td>
                            <td id = "Used_Machine_Total_Time_Name_<?=$Rows['CTNId']?>"></td>
                            <td id = "Used_Machine_Actual_Time_Name_<?=$Rows['CTNId']?>"></td>
                            <td id = "Used_Machine_Down_Time_Name_<?=$Rows['CTNId']?>"></td>
                        </tr>
 
                        <tr id = "details_tr_Title_<?=$Rows['CTNId']?>"  style = "display:none; color:#D09CFA;">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>#</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <td></td>
                            <td></td>
                        </tr>
 
                        <?php 
                            $Counter=1;
                            $total = [];
                            $down_time = []; 
                            $actual_time = []; 
                            $final_actual_time = []; 
                            $final_down_time = []; 

                            $machine_ph = $Controller->QueryData('SELECT * FROM machine_production_history WHERE machine_id = ? AND CTNId = ?' ,[$Rows['machine_id'] , $Rows['CTNId']]); 
                            while($mph = $machine_ph->fetch_assoc()) { 

                                $start_time1 = new DateTime($mph['start_time']);
                                $end_time1 = new DateTime($mph['end_time']);
                                $diff = $start_time1->diff($end_time1);
                                $total_time1 =  $diff->format('%H:%I:%S'); 
                                array_push($total , $total_time1 ); 

                                if($mph['status'] == 'Start Configuration'  || $mph['status']  == 'Start Production' || $mph['status']  == 'Continue Job' ){
                                    array_push($actual_time , $total_time1 ); 
                                    if($mph['status']  == 'Continue Job') {
                                        continue; 
                                    }
                                    // echo $mph['status'] ; echo "><"; 
                                }
                                else {
                                    array_push($down_time , $total_time1 ); 
                                }
                        ?>
                        
                        <tr class = "details_tr_<?=$Rows['CTNId']?>" style = "display:none;"> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?=$Counter?></td>
                            <th><?=$mph['status']?></th>
                            <td><?= $total_time1 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> 
 
                <?php $Counter++; }    ?>
               <?php
                    $sum = strtotime('00:00:00');
                    $sum2=0;
                    foreach ($total as $v){
                        $sum1=strtotime($v)-$sum;
                        $sum2 = $sum2+$sum1;
                    }
                    $sum3=$sum+$sum2;
                    $final_total_time =  date("H:i:s",$sum3);


                    $sum_ = strtotime('00:00:00');
                    $sum2_=0;
                    foreach ($actual_time as $v){
                        $sum1_=strtotime($v)-$sum_;
                        $sum2_ = $sum2_+$sum1_;
                    }
                    $final_actual_time =  date("H:i:s", $sum_+$sum2_ );


                    $sum__ = strtotime('00:00:00');
                    $sum2__=0;
                    foreach ($down_time as $v){
                        $sum1__=strtotime($v)-$sum__;
                        $sum2__ = $sum2__+$sum1__;
                    }
                    $final_down_time =  date("H:i:s",$sum__+$sum2__);
                ?>

                <tr class = "details_tr_<?=$Rows['CTNId']?>" style = "display:none;"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class = "fw-bold" id = "Used_Machine_Total_Time_Value_<?=$Rows['CTNId']?>" > <?= $final_total_time ?>  </td>
                    <td><span style = "display:none;" id = "Used_Machine_Actual_Time_Value_<?=$Rows['CTNId']?>"> <?=$final_actual_time?> </span> </td>
                    <td><span style = "display:none;" id = "Used_Machine_Down_Time_Value_<?=$Rows['CTNId']?>"> <?=$final_down_time?> </span> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> 

                <?php 
                    echo 
                    "<script> 
                        document.getElementById('Used_Machine_Actual_Time_Name_".$Rows['CTNId']."').innerHTML = document.getElementById('Used_Machine_Actual_Time_Value_".$Rows['CTNId']."').innerHTML 
                        document.getElementById('Used_Machine_Down_Time_Name_".$Rows['CTNId']."').innerHTML = document.getElementById('Used_Machine_Down_Time_Value_".$Rows['CTNId']."').innerHTML
                        document.getElementById('Used_Machine_Total_Time_Name_".$Rows['CTNId']."').innerHTML = document.getElementById('Used_Machine_Total_Time_Value_".$Rows['CTNId']."').innerHTML
                    </script>"
                ?>
                <?php endwhile;    } ?>
                </tbody>
        </table>
    </div>
</div>


<script>
    function view_details(id) {
        let tr = document.getElementsByClassName(id);
        console.log(tr);
        var header_id = id.match(/\d+/)[0];

    
    
        for (var i = 0; i < tr.length; i++) {
            if( tr.item(i).style.display == "") 
            {
                tr.item(i).style.display = 'none'; 
                document.getElementById('details_tr_Title_'+ header_id).style.display= "none"; 
                // document.getElementById('details_tr_bottom_'+ header_id).style.display= "none"; 
                
            }
            else 
            {
                tr.item(i).style.display = ""; 
                document.getElementById('details_tr_Title_'+ header_id).style.display= "";
                // document.getElementById('details_tr_bottom_'+ header_id).style.display= ""; 
            }
        }
    } // end of view detials function 

</script>
<?php  require_once '../App/partials/Footer.inc'; ?>