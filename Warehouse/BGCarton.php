<?php  ob_start();
require_once '../App/partials/Header.inc';

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/WAREHOUSE_DEPT';  
if(!in_array( $Gate['VIEW_BG_CARTON_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
  header("Location:index.php?msg=You are not authorized to access this page!" );
}


require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;
 
   

    $SQL="SELECT  ppcustomer.CustName, carton.`CTNQTY`, carton.ProductQTY, carton.ProductName, carton.CTNColor, carton.CTNOrderDate,CTNType, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,
    carton.CTNUnit, carton.JobNo, cartonsales.SaleId, cartonsales.SaleCustomerId,cartonsales.SaleCartonId,cartonsales.SaleQty, cartonsales.SaleCurrency, cartonsales.SalePrice,cartonsales.SaleTotalPrice,
    cartonsales.SaleComment,cartonsales.SaleUserId,cartonsales.SaleDate	,StockOutQTY
    FROM  cartonsales  INNER JOIN carton ON carton.CTNId=cartonsales.SaleCartonId INNER JOIN ppcustomer ON ppcustomer.CustId=cartonsales.SaleCustomerId 
    where (`JobType` = 'OnlyProduct' OR CTNStatus = 'Rejected') AND JobNo != 'NULL' AND SaleStatus='Confirm' AND Amount!='NULL'";
    $Data=$Controller->QueryData($SQL,[]); 

 

 
?>
 
<?php
      if(isset($_GET['MSG']) && !empty($_GET['MSG'])) 
      {
          $MSG=$_GET['MSG'];
          if($_GET['State']==1)
          {
              echo' <div class="alert alert-success alert-dismissible fade show m-3" role="alert"  id = "message">
                      <strong>Well Done!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
          elseif($_GET['State']==0)
          {
              echo' <div class="alert alert-warning alert-dismissible fade show m-3" role="alert" id = "message">
                      <strong>OPPS!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick = "remove_msg(`message`)" ></button>
                    </div>';
          }
      }
?>
<style>
    .wrap {
        text-align: center;
        margin: 0px;
        position: relative;
    }
    .links {
        padding: 0 0px;
        display: flex;
        justify-content: space-between;
        position: relative;
    }
    .wrap:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        border-top: 2px solid black;
        background: black;
        width: 100%;
        transform: translateY(-50%);
    }
    .dot {
        width: 50px;
        height: 25px;
        background: #1CD6CE;
        color:white; 
        font-weight:bold; 
    }
  
 </style>
 


<div class="card shadow m-3"  >
    <div class="card-body d-flex justify-content-between  ">
        <h3 class="m-0 p-0">  
        <a class= "btn btn-outline-primary btn-sm " href="JobCenter.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a> 
            <svg width="49" height="49" viewBox="0 0 881 686" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M440.5 0L68.2668 149.672L440.5 299.344L812.735 149.672L440.5 0Z" fill="#F0DCBE"/>
                <path d="M804.417 539.672L440.502 686V299.344L812.736 149.672V528.347C812.735 533.211 809.488 537.632 804.417 539.672Z" fill="#EBD2AF"/>
                <path d="M76.5831 539.672L440.5 686V299.344L68.2668 149.672V528.345C68.2668 533.211 71.5138 537.632 76.5831 539.672Z" fill="#D2B493"/>
                <path d="M812.735 149.672L440.5 299.344L507.024 473.216C509.723 480.268 518.86 483.711 526.606 480.598L872.681 341.443C879.304 338.779 882.57 332.203 880.262 326.173L812.735 149.672Z" fill="#F0DCBE"/>
                <path d="M68.2668 149.672L440.502 299.344L373.975 473.216C371.277 480.268 362.14 483.711 354.394 480.598L8.31894 341.442C1.69592 338.778 -1.56999 332.201 0.737485 326.172L68.2668 149.672Z" fill="#EBD2AF"/>
                <path d="M812.735 149.672L440.5 0V299.344L812.735 149.672Z" fill="#D2B493"/>
            </svg> 
            <span class = "fs-bold fs-4   " >BG Carton Sales Stock Page</span>  
        </h3>
        
        <div class="d-flex justify-content-end"> 
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:9px;"  title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
        </div> 
    </div>
</div>



<form action="" method="POST">
    <div class="card m-3 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"  style="z-index: 11;">
                    <input type="text" name = "CustomerName" id = "customer" class="form-control " value = "<?php if(isset($CustomerName)) echo $CustomerName ; ?>" 
                        onclick= "HideLiveSearch();" onkeyup="AJAXSearch(this.value);"   placeholder = "Search Company Names" >
                        <div  id="livesearch" class="list-group shadow z-index-2  position-absolute mt-2  w-25 "></div>
                        <input type="hidden" name="CustId" id = "CustId">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
                    <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )"> 
                </div>
            </div>
        </div>                
    </div>
</form>

<div class="card m-3 shadow">
    <div class="card-body">
        <table class= "table " id = "JobTable" >
            <thead style = "font-size:12px;">
                <tr class="table-info">
                    <th>#</th> 
                    <th>JobNo</th>
                    <th title="Company Name">C.Name</th>  
                    <th>Description</th>  
                     
                    <th title="Produced QTY">Sold QTY</th>  
                    <th>Stock Out QTY</th>
                    <th title="Remaining Amount">Available</th> 
                    <th class = "text-center" >Cycle Process</th>
                    <th>OPS</th>
                </tr>
            </thead>
            <tbody style = "font-size:12px;">
              <?php 
                  $COUNTER=1;$Count=1;
                  while($Rows=$Data->fetch_assoc())
                  {
                     $AvalibleQTY=$Rows['SaleQty']-$Rows['StockOutQTY'];
                    ?>
                    
                        <tr>
                            <td><?=$Count?></td> 
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['CustName']?></td> 
                            <td> <?=$Rows['ProductName'].' ( '.$Rows['Size'].' cm) '.$Rows['CTNType'].' Ply'.' - '.$Rows['CTNUnit']?> </td> 
                            <td><?=number_format($Rows['SaleQty'])?></td>
                            <td><?=number_format($Rows['StockOutQTY'])?></td>
                            <td><?=$AvalibleQTY?></td>
                            <!-- <td><?=$Rows['CTNStatus']?></td> -->
                            <td class="text-center">  </td>
                            <td>
                                <a href="BGStockOutForm.php?CartonId=<?=$Rows['SaleCartonId']?>&CustId=<?=$Rows['SaleCustomerId']?>&SoldQTY=<?=$Rows['SaleQty']?>&SaleId=<?=$Rows['SaleId']?>" class="btn btn-outline-primary btn-sm">Stock out</a>
                                <a href="BGCartonSalePrintDetails.php?CartonId=<?=$Rows['SaleCartonId']?>&CustId=<?=$Rows['SaleCustomerId']?>&SoldQTY=<?=$Rows['SaleQty']?>&SaleId=<?=$Rows['SaleId']?>" class="btn btn-outline-primary btn-sm">Print</a>
                            </td>
                           
                        </tr>
                  <?php
                    $Count++;
                  }
              ?>
               
            </tbody>
        </table>  
    </div>
</div>
 
 
<script>
function HideLiveSearch()
{
    document.getElementById('livesearch').style.display = 'none';
}
function PutTheValueInTheBox(inner , id)
{
    let a = document.getElementById('customer').value = inner;
    document.getElementById('livesearch').style.display = 'none';
    document.getElementById('CustId').value = id;     
    console.log(document.getElementById('customer').form.submit());
}
function AJAXSearch(str) 
{

    document.getElementById('livesearch').style.display = '';
    if (str.length == 0)
    {
      return false;
    } 
    else 
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() 
      {
          if (this.readyState == 4 && this.status == 200)  
          {
                var response = JSON.parse(this.responseText);
                var html = ''; 
                    if(response != '-1')
                    {
                        for(var count = 0; count < response.length; count++)
                        {
                                    html += '<a href="#" onclick = "PutTheValueInTheBox( `' + response[count].CustName + '`   , ' + response[count].CustId + ');"  class="list-group-item list-group-item-action" aria-current="true">' ; 
                                    html += response[count].CustName; 
                                    html += '   </a>';
                        }
                    }

                    else html += '<a href="#" class="list-group-item list-group-item-action " aria-current="true"> No Match Found</a> ';
                    document.getElementById('livesearch').innerHTML = html;  
          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
}

      function search(InputId ,tableId)
      {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById(InputId);
          filter = input.value.toUpperCase();
          table = document.getElementById(tableId);
          tr = table.getElementsByTagName("tr");

          // Loop through all table rows, and hide those who don't match the search query
            for (i = 1; i < tr.length; i++) 
            {
                td = tr[i];
                if (td) 
                {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) 
                    {
                        tr[i].style.display = "";
                    } 
                    else 
                    {
                        tr[i].style.display = "none";
                    }
                }
            }
      }

      var fruits = document.getElementById("ListType");
      [].slice.call(fruits.options)
        .map(function(a){
          if(this[a.value]){ 
            fruits.removeChild(a); 
          } else { 
            this[a.value]=1; 
          } 
        },{}); 

      function PutQTYToModal(CTNId)
      {
          document.getElementById("CTNID").value = CTNId; 
      }


      function submit_reel(id)
      {
          let reel = document.getElementById(id); 
          console.log(reel.value);
          if(reel.value > 180 || reel.value < 80) 
          {
              alert('your are not allowed'); 
              reel.value = 80; 
              return ; 
          }

          reel.form.submit();

      }

      function add_reel_size(id) 
      {
          document.getElementById('reel_size_1').value = document.getElementById(id) ; 
      }

</script>
 
<?php  require_once '../App/partials/Footer.inc'; ?>

