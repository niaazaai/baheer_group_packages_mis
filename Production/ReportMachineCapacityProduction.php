<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';

    if( isset($_POST['from']) && !empty($_POST['from']) && isset($_POST['to']) && !empty($_POST['to']) && isset($_POST['machine']) && !empty($_POST['machine']) ) {
 
        $from_date = $Controller->CleanInput($_POST['from']);
        $to_date = $Controller->CleanInput($_POST['to']);
        $machine = $Controller->CleanInput($_POST['machine']);
         
        if($machine == 'ALL') $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE PrBranch = 'Manual' AND PrDate BETWEEN ? AND ?",   [ $from_date , $to_date]);  
        else $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE  TRIM(MachineName) = TRIM(?) AND  PrBranch = 'Manual' AND PrDate BETWEEN ? AND ?", [$machine,$from_date,$to_date]);
    }
    else {
        $DataRows = $Controller->QueryData("SELECT * FROM machineproduction WHERE YEARWEEK(PrDate, 1) = YEARWEEK(CURDATE(), 1) ",  []);
    }
?>

<div class=" m-3">
    <div class="card " >
      <div class="card-body d-flex justify-content-between align-item-center shadow">
            <h3 class="m-0 p-0"> 
                <a class="btn btn-outline-primary   me-1" href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg>
                </a>
               Machine Production Capacity Report  
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
                        <?php $ma = $Controller->QueryData('SELECT machine_id , machine_name , machine_type FROM machine WHERE machine_type = "Manual" '); while($machine=$ma->fetch_assoc()): ?>
                            <?php // if($machine['machine_type'] == 'Production' ):?>
                            <option value="<?=$machine['machine_name']?>"><?=$machine['machine_name']?></option>
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
        <table class= "table table-bordered" >
            <thead>
                <tr class="table-info">
                <th> # </th>
                <th> Date </th>
                <th> Machine Name  </th>
                <th> Location </th>
                <th> Capacity (Hr) </th>
                <th> Produced QTY </th>
                <th> Produced Balance</th>
                <th> Start Time (Hr)</th>
                <th>End Time (Hr)</th>
                <th>Total Time Taken (Hr)</th>
                <!-- <th>Down Time (Hr)</th>
                <th>Actual Time Taken (Hr)</th> -->

                </tr>
            </thead>
            <tbody>
                <?php $counter = 1;  $total = [ ]; $total_time = 0 ;  $Production_qty_total = 0 ;  
                while($Rows = $DataRows->fetch_assoc()):  
                    $Production_qty_total += $Rows['ProductQty1'] ;   
                    // this is to sum the tow start and end time 
                    $start_time = new DateTime($Rows['WorkStartTime']);
                    $end_time = new DateTime($Rows['WorkEndTime']);
                    $diff = $start_time->diff($end_time);
                    $total_time =  $diff->format('%H:%I:%S');  
                    array_push($total , $total_time   ); 
                ?>
                <tr>  
                    <td><?=$counter++?></td>
                    <td><?=$Rows['PrDate']?></td>
                    <td><?=$Rows['MachineName']?></td>
                    <td><?=$Rows['PrBranch']?></td>
                    <td>1000</td>
                    <td><?=$Rows['ProductQty1']?></td>
                    <td>0</td>
                    <td><?=$Rows['WorkStartTime']?></td>
                    <td><?=$Rows['WorkEndTime']?></td>
                    <td><?=$total_time?></td>
                </tr>
                <?php endwhile; ?>
                <?php
                    $sum = strtotime('00:00:00');
                    $sum2=0;
                    foreach ($total as $v){
                        $sum1=strtotime($v)-$sum;
                        $sum2 = $sum2+$sum1;
                    }
                    $sum3=$sum+$sum2;
                    $total_time =  date("H:i:s",$sum3);
                ?>

                <tr>
                    <td colspan = 5  class= "fw-bold text-center"> Total</td>
                    <td><?= $Production_qty_total; ?></td>
                    <td colspan = 3 ></td>
                    <td><?= $total_time; ?></td>

                </tr>
                </tbody>
        </table>
    </div>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>