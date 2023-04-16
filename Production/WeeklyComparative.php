<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';
   



    if(isset($_POST['from']) && !empty($_POST['from']) && isset($_POST['to']) && !empty($_POST['to']) ) {
 
      $from_date = $Controller->CleanInput($_POST['from']);
      $to_date = $Controller->CleanInput($_POST['to']);
      
      $production = $Controller->QueryData("SELECT  `ProDate`,  SUM(`ProQty`) AS Produced_Qty, `ProBrach` 
      FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
      INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
      WHERE ProStatus='Accept' AND ProBrach='Production' AND ProDate BETWEEN ? AND ? GROUP BY ProDate ORDER BY  ProDate",[$from_date , $to_date]);

      $manual = $Controller->QueryData("SELECT  `ProDate`,  SUM(`ProQty`) AS Produced_Qty, `ProBrach`  
      FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
      INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
      WHERE ProStatus='Accept' AND ProBrach='Manual' AND ProDate BETWEEN ? AND ? GROUP BY  ProDate ORDER BY ProDate",[$from_date , $to_date]);

      // var_dump($manual);
      // var_dump($production);
      
      

    }
    else {

      $production = $Controller->QueryData("SELECT  `ProDate`,  SUM(`ProQty`) AS Produced_Qty, `ProBrach` 
      FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
      INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
      where ProStatus='Accept' and ProBrach='Production' and ProDate > DATE_SUB(NOW(), INTERVAL 1 WEEK) group by  ProDate order by ProDate",[]);

      $manual = $Controller->QueryData("SELECT  `ProDate`,  SUM(`ProQty`) AS Produced_Qty, `ProBrach`  
      FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
      INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
      where ProStatus='Accept' and ProBrach='Manual' and ProDate > DATE_SUB(NOW(), INTERVAL 1 WEEK) group by  ProDate order by ProDate ",[]);
 
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
                Production Comparative Report 
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

<div class="collapse shadow" style="position: absolute; z-index: 1000; width: 60%; left: 39%; margin-top:-21px; " id="colapse1">
    <div class="card card-body border shadow">
      <form action="" method="post">
        <div class="row">
          <div class="col-lg-5 col-sm-12 col-md-5">
            <div class="form-floating">
                <input type="date" name = "from" class="form-control"  id = " " placeholder="  " >
                <label for="Reel"> From Date  </label>
            </div>
          </div>
          <div class="col-lg-5 col-sm-12 col-md-5">
            <div class="form-floating">
                <input type="date" name = "to" class="form-control" placeholder="  " >
                <label for="Reel"> To Date  </label>
            </div>
          </div>
          <div class="col-lg-2 col-sm-12 col-md-2  ">
            <div class="d-grid gap-2 mt-2">
              <button type="submit" class="btn btn-primary  ">Find</button>
            </div>
          </div>
        </div>
      </form>
    </div>
</div>


<div class="card m-3 shadow">
    <div class="card-body pt-2">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <table class= "table table-bordered" >
              <thead>
                  <tr class="table-info">
                    <th> # </th>
                    <th> Date </th>
                    <th> Produced Quantity (Production) </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; $Production_qty_total = 0 ;  while($Rows = $production->fetch_assoc()) :  $Production_qty_total += $Rows['Produced_Qty'] ;  ?>
                  <tr>  
                    <td><?=$counter++?></td>
                    <td><?=$Rows['ProDate']?></td>
                    <td><?=$Rows['Produced_Qty']?></td>
                  </tr>
                  <?php endwhile; ?>
                  <tr>
                    <td colspan = 2  class= "fw-bold text-center"> Total</td>
                    <td><?= $Production_qty_total; ?></td>
                  </tr>
                </tbody>
            </table>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12">
              <table class= "table table-bordered " >
                <thead>
                    <tr class="table-info">
                      <th> Produced Quantity (Manual) </th>
                      <th> Total Produced QTY </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $Manual_qty_total = 0 ;  while($Rows = $manual->fetch_assoc()) : $Manual_qty_total += $Rows['Produced_Qty'];   ?>
                    <tr>  
                      <td><?=$Rows['Produced_Qty']?></td>
                      <td><?=$Rows['ProDate']?></td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                      <!-- <td colspan = 2  class= "fw-bold text-center"> Total</td> -->
                      <td><?= $Manual_qty_total; ?></td>
                      <td><?= $Manual_qty_total; ?></td>
                    </tr>
                  </tbody>
              </table>
          </div>
        </div>
    </div>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>