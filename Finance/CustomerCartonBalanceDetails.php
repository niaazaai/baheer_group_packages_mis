
<?php  
  
  require_once '../App/partials/Header.inc';  
  if((  isset($_GET['CTNId']) && !empty('CTNId') ) ) {
  
    
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
  else {
   header('Location:CustomerCartonBalance.php');
  }
    require_once '../App/partials/Menu/MarketingMenu.inc'; 
  ?>
  

  <div class="card m-3 shadow ">
  <div class="card-body  d-flex justify-content-between">
      <h3 class = "my-0">  
          <a class="btn btn-outline-primary  " href="CustomerCartonBalance.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
          </a>

          <svg width="45" height="45" viewBox="0 0 57 56" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M48.6544 39.472L36.8834 45.169L32.3364 35.774L44.1074 30.077L48.6544 39.472ZM45.8014 15.555L55.5234 35.644L49.6384 38.492L39.9154 18.404L45.8014 15.555ZM40.6184 46.767L56.9304 39.163L56.5494 37.56L38.8644 45.765C38.0264 45.494 37.1084 45.433 36.1894 45.655C36.0294 45.692 35.8724 45.739 35.7184 45.79L23.5754 22.832C25.0824 21.186 23.6874 17.597 20.7334 17.973C20.4424 18.01 20.3374 18.041 20.1304 18.06C17.3334 17.866 14.5304 16.943 11.9914 15.601C11.9754 15.307 11.9634 15.014 11.9464 14.72C11.7984 12.3 10.3914 10.167 7.75536 10.016C5.55036 9.89 2.90336 11.78 3.05136 14.207C3.40136 19.937 3.39736 21.341 3.37936 26.834L3.32236 26.832C3.35736 27.562 3.39136 28.772 3.42936 29.504C3.48436 30.64 3.88436 31.552 4.48236 32.239C4.48736 32.247 4.48836 32.259 4.49536 32.265C5.20236 33.352 5.14536 34.506 5.71036 35.668C4.66736 40.623 1.37936 45.574 0.105356 50.48C-0.828644 54.083 4.72936 55.607 5.66336 52.012C6.94736 47.071 10.8764 42.074 11.9294 37.078C11.9834 36.824 12.0024 36.58 11.9984 36.349C15.4584 39.924 17.7824 45.736 18.2194 50.812C18.5354 54.49 24.3014 54.518 23.9834 50.812C23.2544 42.344 18.9374 34.127 12.3124 29.035C12.2914 28.609 12.2714 28.181 12.2504 27.757L12.2724 27.759C12.2824 24.312 12.2904 25.471 12.2224 22.025C14.6074 22.938 17.1174 23.519 19.6354 23.712L19.6314 23.782C20.5254 23.775 21.0984 23.711 21.9814 23.599C22.1454 23.578 22.2884 23.536 22.4324 23.495L34.1934 46.646C32.7744 47.813 32.0544 49.722 32.5074 51.625C33.1384 54.287 35.8194 55.937 38.4844 55.307C41.1464 54.673 42.7964 51.993 42.1644 49.33C41.9184 48.298 41.3604 47.419 40.6184 46.767ZM37.7224 52.109C36.8244 52.322 35.9194 51.765 35.7064 50.869C35.4924 49.972 36.0504 49.065 36.9464 48.852C37.8424 48.638 38.7494 49.197 38.9624 50.093C39.1754 50.992 38.6204 51.895 37.7224 52.109ZM38.9304 19.382L43.4784 28.777L31.7074 34.474L27.1594 25.08L38.9304 19.382ZM7.66736 0C10.0594 0 11.9984 1.939 11.9984 4.331C11.9984 6.723 10.0594 8.662 7.66736 8.662C5.27536 8.662 3.33636 6.723 3.33636 4.331C3.33636 1.939 5.27536 0 7.66736 0Z" fill="#010002"/>
          </svg>
          Finished Goods Delivery Details</h3> 
      </h3>
      <div>
      <a  onclick = 'Print()' class="btn btn-outline-primary  my-1" title="Click to Print Customer List ">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
          <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
          <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
        </svg>
        Print
        </a>
        <a href="#" type="button"  onclick="export_data()"  class="btn btn-outline-success  my-1" title="New Customer">  
        <svg width="25" height="25" viewBox="0 0 111 108" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M57.55 0H64.975V10C77.488 10 90 10.025 102.512 9.962C104.625 10.049 106.95 9.9 108.787 11.162C110.074 13.012 109.925 15.362 110.012 17.487C109.95 39.187 109.975 60.875 109.988 82.562C109.926 86.2 110.325 89.912 109.563 93.5C109.063 96.1 105.938 96.162 103.85 96.25C90.9 96.287 77.938 96.225 64.975 96.25V107.5H57.212C38.162 104.037 19.074 100.838 0 97.5V10.013C19.188 6.675 38.375 3.388 57.55 0Z" fill="#207245"/>
            <path d="M64.9746 13.75H106.225V92.5H64.9746V85H74.9746V76.25H64.9746V71.25H74.9746V62.5H64.9746V57.5H74.9746V48.75H64.9746V43.75H74.9746V35H64.9746V30H74.9746V21.25H64.9746V13.75Z" fill="white"/>
            <path d="M79.9746 21.25H97.4746V30H79.9746V21.25Z" fill="#207245"/>
            <path d="M37.0251 32.962C39.8501 32.762 42.6881 32.587 45.5251 32.45C42.1927 39.2936 38.8303 46.1227 35.4381 52.937C38.8761 59.937 42.3871 66.887 45.8371 73.887C42.8279 73.7143 39.8198 73.5226 36.8131 73.3119C34.6881 68.0989 32.1001 63.0619 30.5751 57.6119C28.8761 62.6869 26.4501 67.4739 24.5011 72.4499C21.7631 72.4119 19.0251 72.2999 16.2881 72.1869C19.5001 65.8999 22.6001 59.562 25.9121 53.312C23.1001 46.874 20.0121 40.5619 17.1121 34.1619C19.8621 33.9989 22.6121 33.837 25.3621 33.687C27.2241 38.575 29.2611 43.3989 30.8001 48.4119C32.4491 43.0999 34.9121 38.1 37.0251 32.962Z" fill="white"/>
            <path d="M79.9746 35H97.4746V43.75H79.9746V35ZM79.9746 48.75H97.4746V57.5H79.9746V48.75ZM79.9746 62.5H97.4746V71.25H79.9746V62.5ZM79.9746 76.25H97.4746V85H79.9746V76.25Z" fill="#207245"/>
        </svg>

            Excel
        </a>
        

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
                 <span class= "badge bg-danger"> <span id= "topJobNo"></span> Job Number</span>
                 <span class= "badge bg-success"> <span id= "orderQTY1"></span>   Order QTY</span>
                 <span class= "badge bg-info"> <span id= "ProducedQTY1"></span>  Produced QTY</span>
            </div>

        </div>
      </div>

  </div>
</div>

<div class="card m-3 shadow ">
  <div class="card-body">
      <div class="table-responsive">
          <table class="table" id="sss">
              <thead class=" text-center">
                  <tr>
                      <th class="text-center">GDN</th>
                      <th class="text-center">Date</th> 
                      <th class="text-center">Driver </th>
                      <th class="text-center">Vehicle</th>
                      <th class="text-center">Vehicle No</th>
                      <th class="text-center">Mobile</th>
                      <!-- <th class="text-end">Produced QTY</th> -->
                      <th class="text-end">Out QTY</th>
                      <th class="text-end">Remaining QTY</th>
                      <th class="text-center">Comment</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $ProduceQTY = 0 ; $OutQTY = 0 ; $Remain = 0 ; 
                  while($Rows = $DataRows->fetch_assoc()) : ?>
                    <span style = "display:none;" id = "description"><?= $Rows['ProductName']  . ' ('  .  $Rows['CTNLength'] . ' X '.  $Rows['CTNWidth'] .' X ' . $Rows['CTNHeight']. ') -  ' . $Rows['PrCtnType']  . ', ' . $Rows['CTNUnit'];  ?></span>
                          <span id = "orderQTY" style = "display:none;"  class = "text-end" ><?= number_format($Rows['CTNQTY']) ?></span>
                      <span style = "display:none;"  id = "tableJobNo"><?=$Rows['JobNo'] ?></span>
                      <span style = "display:none;"  id = "ProducedQTY"><?=$Rows['ProQty'] ?></span>

                      <tr>  
                          <td class="text-center"><?=$Rows['GDNumber'] ?> </td>
                          <td class="text-center"><?=$Rows['CtnStockOutDate'] ?></td>
                          <td class="text-center"><?= $Rows['CtnDriverName'] ?></td>
                          <td class="text-center"><?= $Rows['CtnCarName'] ?></td>
                          <td class="text-center"><?= $Rows['CtnCarNo'] ?></td>
                          <td class="text-center"><?= $Rows['CtnDriverMobileNo'] ?></td>
                          <!-- <td class = "text-end"><?php echo  number_format($Rows['ProQty'] );                     $ProduceQTY += $Rows['ProQty']  ?></td> -->
                          <td class = "text-end"><?php echo number_format($Rows['CtnOutQty']);                      $OutQTY +=  $Rows['CtnOutQty']  ?></td>
                          <td class = "text-end"><?php echo number_format($Rows['ProQty'] - $Rows['CtnOutQty']);    $Remain +=   $Rows['ProQty'] - $Rows['CtnOutQty'] ;  ?></td>
                          <td class="text-center"><?= $Rows['CoutComment'] ?></td>
                      </tr>

                  <?php endwhile;  ?>

                    <tr>
                        <td  colspan = '6' class = "text-center fw-bold" >Total</td>
                         
                        <!-- <td  class = "text-end fw-bold"><?php    echo number_format ( $ProduceQTY) ?></td> -->
                        <td  class = "text-end fw-bold" ><?php    echo number_format ($OutQTY ) ?></td>
                        <td  class = "text-end fw-bold" ><?php    echo number_format ($Remain) ?></td>
                        <td colspan = '1' ></td>
                    </tr>
              </tbody>             
          </table>
      </div>
  </div>
</div>

<script src="../Assets/SheetJs/SheetJs.js"></script>
<script>

let description = document.getElementById('description').innerHTML; 
document.getElementById('desc').innerHTML =   description;  
document.getElementById('orderQTY1').innerHTML = document.getElementById('orderQTY').innerHTML;  
document.getElementById('topJobNo').innerHTML = document.getElementById('tableJobNo').innerHTML;  
document.getElementById('ProducedQTY1').innerHTML = document.getElementById('ProducedQTY').innerHTML;

function export_data() {
  let data=document.getElementById('sss');
  var fp=XLSX.utils.table_to_book(data,{sheet:'text'});
  XLSX.write(fp,{bookType:'xlsx',type:'base64'});
  XLSX.writeFile(fp, description + '.xlsx');
}

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
                    <img src="../public/img/only-logo-brand.png" width = "180px" height= "150px"   alt="BGC Logo"> 
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
              <th style="padding-left:970px; padding-top:50px;font-weight:bold;font-size:20px; float:right;">
                     Job NO:&nbsp;&nbsp;<span id="topJobNo"></span><br>
              </th>
            </tr> 
            <tr>
                  <td style="padding-left:30px;font-weight:bold;font-size:20px;"><span id = "desc" style = "color:black;"> </span> </td>
                  <td  style="padding-left:870px;font-weight:bold;font-size:20px; float:right;">  Order QTY:&nbsp;&nbsp;<span id="orderQTY1"></span></td>
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
              <th class="border th">Remaining QTY</th>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>

let description = document.getElementById('description').innerHTML; 
document.getElementById('desc').innerHTML =   description;  
document.getElementById('orderQTY1').innerHTML = document.getElementById('orderQTY').innerHTML;  
document.getElementById('topJobNo').innerHTML = document.getElementById('tableJobNo').innerHTML;  


function export_data()
{
    let data=document.getElementById('tab');
    var fp=XLSX.utils.table_to_book(data,{sheet:'text'});
    XLSX.write(fp,{bookType:'xlsx',type:'base64'});
    XLSX.writeFile(fp,'test.xlsx');

} 


</script>

    </div>
</div>
<?php  require_once '../App/partials/Footer.inc'; ?>