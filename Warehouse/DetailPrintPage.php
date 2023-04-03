
<?php ob_start();  
  require_once '../App/partials/Header.inc';  

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/WAREHOUSE_DEPT';
if(!in_array( $Gate['VIEW_PRINTED_DETAILS_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
}
  if((  isset($_GET['CTNId']) && !empty('CTNId') ) ) {
  
    
    // echo $_GET['CTNId'] ; 
    $PROId=$_GET['PROId'];
  
    $Query = "SELECT `CtnoutId`, carton.CTNId,  PrCtnType  , CTNUnit  ,`CtnStockOutDate`, ppcustomer.CustName, carton.ProductName,carton.`CTNWidth`,cartonproduction.ProId, 
    carton.`CTNHeight`, carton.`CTNLength`, carton.CTNQTY, cartonproduction.ProQty, `CtnOutQty`, `CtnDriverName`, `CtnCarNo`, 
    `CtnDriverMobileNo`, `CtnCarName` , `CoutComment`, `OutDateTime`, `GDNumber`,ProductQTY, cartonstockout.CtnOutQty  , carton.JobNo 
    FROM `cartonstockout` INNER JOIN carton ON carton.CTNId=cartonstockout.CtnJobNo 
    left outer JOIN cartonproduction ON cartonproduction.ProId=cartonstockout.PrStockId 
    INNER JOIN ppcustomer ON ppcustomer.CustId=cartonstockout.CtnCustomerId  
    where cartonproduction.ProStatus='Accept' and CTNId= ? order by ProSubmitDate desc"; 
    
    $DataRows = $Controller->QueryData($Query ,  [ $_GET['CTNId'] ] ); 
  
  }
  else 
  {
    header('Location:CustomerCartonBalance.php');
  }
  require_once '../App/partials/Menu/MarketingMenu.inc'; 
  ?>
  

  <div class="card m-3 shadow ">
  <div class="card-body  d-flex justify-content-between">
      <h3 class = "my-0">  
          <a class="btn btn-outline-primary  " href="JobCenter.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
          </a>

          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
          </svg>
          Driver & Loaded Jobs Printing Page</h3> 
      </h3>
      <div>
        <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary my-1 ms-1" title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
			</a>
    </div>
  </div>
</div>


<div class="card m-3 shadow ">
  <div class="card-body  ">
     
      <div class="row ">
        <div class="col-lg-5 py-2  " style = "border:3px dotted green; margin-left:15px;    "    > 
         
            <div>
               <span class = " fw-bold"> Description: </span> <span id = "desc" style = "color:#FA8b09" > </span> 
            </div>
            
            <div>
                 <span class= "badge bg-danger" > <span id= "topJobNo"></span> Job Number</span>
                <span  class= "badge bg-success" > <span id= "orderQTY1"></span>   Order QTY</span>
                <span  class= "badge bg-info" > <span id= "ProducedQTY1"></span> Produced QTY</span>
                <span  class= "badge bg-warning" > <span id= "RemainingQTY1"></span> Remaining QTY</span>
            </div>

        </div>
      </div>

  </div>
</div>

<div class="card m-3 shadow ">
  <div class="card-body">
      <div class="table-responsive">
          <table class="table" id="sss">
              <thead class=" text-center table-info">
                  <tr>
                      <th class="text-center">GDN</th>
                      <th class="text-center">Date</th> 
                      <th class="text-center">Driver </th>
                      <th class="text-center">Vehicle</th>
                      <th class="text-center">Vehicle No</th>
                      <th class="text-center">Mobile</th>
                      <!-- <th class="text-end">Produced QTY</th> -->
                      <th class="text-end">Out QTY</th>
                      <th class="text-center">Comment</th>
                      <th class="text-center">Print</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $ProduceQTY = 0 ; $OutQTY = 0 ; $Remain = 0 ; 
                  while($Rows = $DataRows->fetch_assoc()) : ?>
                    <span style = "display:none;" id = "description"><?= $Rows['ProductName']  . ' ('  .  $Rows['CTNLength'] . ' X '.  $Rows['CTNWidth'] .' X ' . $Rows['CTNHeight']. ') -  ' . $Rows['PrCtnType']  . ', ' . $Rows['CTNUnit'];  ?></span>
                          <span id = "orderQTY" style = "display:none;"  class = "text-end" ><?= number_format($Rows['CTNQTY']) ?></span>
                          <span id = "ProducedQTY" style = "display:none;"  class = "text-end" ><?= ($Rows['ProductQTY']) ?></span>
                          <span id = "RemainingQTY" style = "display:none;"  class = "text-end" ><?= number_format($Rows['ProductQTY']-$Rows['CtnOutQty']) ?></span>


                      <span style = "display:none;"  id = "tableJobNo"><?=$Rows['JobNo'] ?></span>

                      <tr>  
                          <td class="text-center"><?=$Rows['CtnoutId'] ?> </td>
                          <td class="text-center"><?=$Rows['OutDateTime'] ?></td>
                          <td class="text-center"><?= $Rows['CtnDriverName'] ?></td>
                          <td class="text-center"><?= $Rows['CtnCarName'] ?></td>
                          <td class="text-center"><?= $Rows['CtnCarNo'] ?></td>
                          <td class="text-center"><?= $Rows['CtnDriverMobileNo'] ?></td>
                          <!-- <td class = "text-end"><?php echo  number_format($Rows['ProQty'] ); $ProduceQTY += $Rows['ProQty']  ?></td> -->
                          <td class = "text-end"><?php echo number_format($Rows['CtnOutQty']); $OutQTY +=  $Rows['CtnOutQty']  ?></td>
                          <td class="text-center"><?= $Rows['CoutComment'] ?></td>
                          <td class="text-center">
                          <?php  if(in_array( $Gate['VIEW_PRINT_BUTTON'] , $_SESSION['ACCESS_LIST']  )) {?>
                                <a href="GatePassPrint.php?PROId=<?=$Rows['ProId']?>&CTNId=<?=$Rows['CTNId']?>&CtnoutId=<?=$Rows['CtnoutId']?>" class="btn btn-outline-primary  btn-sm" target="_blank">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                      <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                      <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                  </svg>
                                  Print
                                </a> 
                          <?php } ?> 
                          </td>
                      </tr>

                  <?php endwhile;  ?>

                    <tr>
                        <td  colspan = '6' class = "text-center fw-bold" >Total</td>
                         
                        <td   id = "out_qty_total"  class = "text-end fw-bold" ><?=  ($OutQTY ) ?></td>
                        <!-- <td class = "text-end fw-bold "  >  <?php    echo number_format ($Remain) ?></td> -->
                        <td colspan = '2' ></td>
                    </tr>
              </tbody>             
          </table>
      </div>
  </div>
</div>

<script>

let description = document.getElementById('description').innerHTML; 
document.getElementById('desc').innerHTML =   description;  
document.getElementById('orderQTY1').innerHTML = document.getElementById('orderQTY').innerHTML;  
document.getElementById('ProducedQTY1').innerHTML = document.getElementById('ProducedQTY').innerHTML; 

 let pro =  (document.getElementById('ProducedQTY').innerHTML ); 
 let out =  (document.getElementById('out_qty_total').innerHTML );
document.getElementById('RemainingQTY1').innerHTML = pro-out;
document.getElementById('topJobNo').innerHTML = document.getElementById('tableJobNo').innerHTML;  
 

function Print()
{
    var printContent = document.getElementById("print_area");
    var WinPrint = window.open('', 'directories=no,fullscreen=yes,location=no', 'width=auto,height=auto');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
 
}

</script>


<div id="print_area" class = "m-5" style = "display:none ; width:21cm ">
    <div class="padding-left:50px; padding-top:50px;">
        <style>
            .border
            {
                border: 1px solid black;
                border-collapse: collapse;
                width:1200px;
                margin-left:30px;
                margin-right:30px;
                font-size:20px;
                text-align:center;
                /* padding:5px; */
            }
            .th{
                background: lightblue;
                padding:6;
            }
            
          .remove_table , .top_th  
            {
              border: none;
              border-collapse: collapse;
          }
      </style>
<?php
  if((  isset($_GET['CTNId']) && !empty('CTNId') ) )
  {
      // echo $_GET['CTNId'] ; 
      $Query = "SELECT `CtnoutId`, carton.CTNId,  PrCtnType  , CTNUnit  ,`CtnStockOutDate`, ppcustomer.CustName, carton.ProductName,carton.`CTNWidth`, 
      carton.`CTNHeight`, carton.`CTNLength`, carton.CTNQTY, cartonproduction.ProQty, `CtnOutQty`, `CtnDriverName`, `CtnCarNo`, 
      `CtnDriverMobileNo`, `CtnCarName` , `CoutComment`, `OutDateTime`, `GDNumber`, cartonstockout.CtnOutQty  , carton.JobNo 
      FROM `cartonstockout` INNER JOIN carton ON carton.CTNId=cartonstockout.CtnJobNo 
      left outer JOIN cartonproduction ON cartonproduction.ProId=cartonstockout.PrStockId 
      INNER JOIN ppcustomer ON ppcustomer.CustId=cartonstockout.CtnCustomerId 
      where cartonproduction.ProStatus='Accept' and CTNId= ? order by ProSubmitDate desc"; 
      
      $DataRows = $Controller->QueryData($Query ,  [ $_GET['CTNId'] ] ); 
  }
?>
        <table class=".remove_table">
            <tr>
                <th th style="padding-left:20px;margin-top:15px;">
                    <!-- <img src="../public/img/Logo.png" width = "210px" height= "100px"   alt="BGC Logo">  -->
                </th>
                <th> 
                    <h3 style="padding-left:280px; font-size:25px; margin-top:20px;" > Baheer Group Of Companies </h3>
                    <p style= "padding-left:280px; font-size:20px;"> Finished Goods Delivery Details </p>
                </th>
            </tr>  
           
        </table>
        <table>
            <tr>
              <th style="padding-left:30px;padding-top:50px;font-weight:bold;font-size:20px;text-align:left; "> 
                 Description&nbsp;:  
              </th>
              <th style="padding-left:780px; padding-top:50px;font-weight:bold;font-size:20px; float:right;">
                     Job NO:&nbsp;&nbsp;<span id="topJobNo"></span><br>
              </th>
            </tr> 
            <tr>
                  <td style="padding-left:30px;font-weight:bold;font-size:20px;"><span id = "desc" style = "color:black;"> </span> </td>
                  <td  style="padding-left:700px;font-weight:bold;font-size:20px; float:right;">  Order QTY:&nbsp;&nbsp;<span id="orderQTY1"></span></td>
            </tr>
        </table>

        <table class="remove_table" style="margin-top:30px; margin-left:30px;margin-right:30px;">
            <tr>
              <th class="border th">GDN</th>
              <th class="border th">Date</th>
              <th class="border th">Driver </th>
              <th class="border th">Vehicle</th>
              <th class="border th">Vehicle No</th>
              <th class="border th">Mobile</th>
              <th class="border th">Produced QTY</th>
              <th class="border th">Out QTY</th>
              <th class="border th">Comment</th>
            </tr>
                  <?php $ProduceQTY = 0 ; $OutQTY = 0 ; $Remain = 0 ; 
                  while($Rows = $DataRows->fetch_assoc()) : ?>
                    <span style = "display:none;" id = "description"><?= $Rows['ProductName']  . '('  .  $Rows['CTNLength'] . ' X '.  $Rows['CTNWidth'] .' X ' . $Rows['CTNHeight']. ') -  ' . $Rows['PrCtnType']  . ', ' . $Rows['CTNUnit'];  ?></span>
                    <span id = "orderQTY" style = "display:none;"  class = "text-end" ><?= number_format($Rows['CTNQTY']) ?></span>
                    <span style = "display:none;"  id = "tableJobNo"><?=$Rows['JobNo'] ?></span>

                      <tr>  
                          <td class="border"><?=$Rows['GDNumber'] ?> </td>
                          <td class="border"><?=$Rows['CtnStockOutDate'] ?></td>
                          <td class="border"><?= $Rows['CtnDriverName'] ?></td>
                          <td class="border"><?= $Rows['CtnCarName'] ?></td>
                          <td class="border"><?= $Rows['CtnCarNo'] ?></td>
                          <td class="border"><?= $Rows['CtnDriverMobileNo'] ?></td>
                          <td class = "border text-end"><?php echo  number_format($Rows['ProQty'] );$ProduceQTY += $Rows['ProQty']  ?></td>
                          <td class = "border text-end"><?php echo number_format($Rows['CtnOutQty']);$OutQTY +=  $Rows['CtnOutQty']  ?></td>
                          <td class = "border text-end"><?php echo number_format($Rows['ProQty'] - $Rows['CtnOutQty']);$Remain +=   $Rows['ProQty'] - $Rows['CtnOutQty'] ;  ?></td>
                          <td class="border"><?= $Rows['CoutComment'] ?></td>
                      </tr>

                  <?php endwhile;  ?>

                    <tr>
                        <td class="border" colspan = '6' class = "text-center fw-bold" >Total</td>
                         
                        <td  class = "border text-end fw-bold"><?php    echo number_format ( $ProduceQTY) ?></td>
                        <td  class = "border text-end fw-bold" ><?php    echo number_format ($OutQTY ) ?></td>
                        <td  class = "border text-end fw-bold" ><?php    echo number_format ($Remain) ?></td>
                        <td class="border" colspan = '1' ></td>
                    </tr>           
          </table>
    </div>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>