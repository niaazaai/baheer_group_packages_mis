 <!-- Starting area of back-end logic-->
<?php 
  ob_start(); 
  require_once '../App/partials/Header.inc';   
  require_once '../App/partials/Menu/MarketingMenu.inc'; 
  $Gate = require_once  $ROOT_DIR . '/Auth/Gates/INTERNAL_JOB';

 
  if(!in_array( $Gate['VIEW_INTERNAL_JOB'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
  }

  $SQL="SELECT `ProId`, `CtnId1`, CustId,`ProDate`, CTNId,`ProSubmitDate`, `ProSubmitBy`, `CompId`,  `ProQty` ,`ProOutQty`, `ProBrach`, `ProComment`, `PrCtnType`, ppcustomer.CustName, carton.`CTNQTY`, 
  carton.ProductQTY, carton.ProductName, carton.CTNColor, carton.CTNOrderDate,CTNType, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size, carton.CTNUnit, 
  carton.JobNo FROM `cartonproduction` 
  INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1
  where 
  ProStatus='Accept' and ProQty-ProOutQty > 0 OR (`JobType` = 'OnlyProduct' OR CTNStatus = 'Rejected' OR ppcustomer.CustName = 'BGC' ) AND JobNo != 'NULL' 
  order by ProSubmitDate desc";

  $SQL = "SELECT  CustId,  CTNId, CustName,  CTNQTY,  ProductQTY, UsedQty,
   carton.ProductName, carton.CTNColor, carton.CTNOrderDate,CTNType, 
   CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size, carton.CTNUnit, 
   carton.JobNo FROM carton   
   INNER JOIN ppcustomer ON ppcustomer.CustId=Carton.CustId1 
   WHERE (`JobType` = 'OnlyProduct' OR CTNStatus = 'Rejected' OR ppcustomer.CustName = 'BGC' ) AND JobNo != 'NULL'"; 
  $Data=$Controller->QueryData($SQL,[]); 
?>

<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class= "btn btn-outline-primary btn-sm " href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
              </a>  
 
          <svg width="55" height="55" viewBox="0 0 881 686" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M440.5 0L68.2668 149.672L440.5 299.344L812.735 149.672L440.5 0Z" fill="#F0DCBE"/>
              <path d="M804.417 539.672L440.502 686V299.344L812.736 149.672V528.347C812.735 533.211 809.488 537.632 804.417 539.672Z" fill="#EBD2AF"/>
              <path d="M76.5831 539.672L440.5 686V299.344L68.2668 149.672V528.345C68.2668 533.211 71.5138 537.632 76.5831 539.672Z" fill="#D2B493"/>
              <path d="M812.735 149.672L440.5 299.344L507.024 473.216C509.723 480.268 518.86 483.711 526.606 480.598L872.681 341.443C879.304 338.779 882.57 332.203 880.262 326.173L812.735 149.672Z" fill="#F0DCBE"/>
              <path d="M68.2668 149.672L440.502 299.344L373.975 473.216C371.277 480.268 362.14 483.711 354.394 480.598L8.31894 341.442C1.69592 338.778 -1.56999 332.201 0.737485 326.172L68.2668 149.672Z" fill="#EBD2AF"/>
              <path d="M812.735 149.672L440.5 0V299.344L812.735 149.672Z" fill="#D2B493"/>
          </svg>

        
          
         BG Finished Goods <span style= "color:#FA8b09;"> </span>
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
           
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 
 
<!-- Start of second Top Head Card which has dropdown and search functioanlity-->
<div class="card m-3"> <!-- start of the card div -->
   <div class="card-body "><!-- start of the card-body div -->
      <div class="form-floating">
          <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'OrderTable' )">
          <label for="Reel">Search Anything</label>
      </div>
    </div> <!-- End of the card-body div -->
</div><!-- End of the card div -->
<!-- End of second Top Head Card which has dropdown and search functioanlity -->


<!-- Start body of table Card -->
<div class="card m-3"> <!-- Start tag of card div -->
    <div class="card-body table-responsive   "><!-- start of table div -->
    <form action="" id="FORM" method="POST">
            <div class = "mb-2 text-end"  >
                <a href = "#" onclick = "PutSearchTermToInputBox('')"><span class = "badge bg-danger">All Jobs</span></a>
                <a href = "#" onclick = "PutSearchTermToInputBox('Carton')"><span class = "badge bg-warning">Carton</span></a>
                <a href = "#" onclick = "PutSearchTermToInputBox('Box')"><span class = "badge bg-info">Box</span></a>
                <a href = "#" onclick = "PutSearchTermToInputBox('Sheet')"><span class = "badge bg-danger">Sheet</span></a>
                <a href = "#" onclick = "PutSearchTermToInputBox('Tray')"><span class = "badge bg-success">Tray</span></a>
                <a href = "#" onclick = "PutSearchTermToInputBox('Separator')"><span class = "badge bg-primary">Separator</span></a>
                <a href = "#" onclick = "PutSearchTermToInputBox('Belt')"><span class = "badge bg-dark">Belt</span></a>
            </div>
            <table class="table p-0 m-0" id="OrderTable">
                <thead class="table-info">
                    <tr>
                        <th></th>
                        <th >#</th>
                        <th>Job #</th>
                        <th>Ply</th>
                        <th>P.Type</th>
                        <th>Customer</th>
                        <th>Product Name</th>
                        <th>Size(LxWxH)cm</th>
                        <th>Color</th>
                        <th>Order QTY</th>
                        <th>Prod.QTY</th>
                        <th>Out QTY</th>
                        <th>Remains QTY</th>
                        <th>OPS</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $Count=1;
                      while($Rows=$Data->fetch_assoc())
                      {
                      
                        ?>
                            <input type="hidden" name="ReminQTY" id="ReminQTY" value="<?=$Rows['ProductQTY']-$Rows['UsedQty']?>">
                            <tr>
                              <td>
                                  <a href = "#"onclick = "view_details(`details_tr_<?=$Rows['CTNId']?>`)" class = "btn " >
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle p-0 m-0" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                      </svg> 
                                  </a>
                                </td>
                                <td><?=$Count?> </td>
                                <td><?=$Rows['JobNo']?></td>
                                <td><?=$Rows['CTNType'].' Ply'?></td>
                                <td><?=$Rows['CTNUnit']?></td>
                                <td><?=$Rows['CustName']?></td>
                                <td><?=$Rows['ProductName']?></td>
                                <td><?=$Rows['Size']?></td>
                                <td><?=$Rows['CTNColor']?></td>
                                <td><?=$Rows['CTNQTY']?></td>
                                <td><?=$Rows['ProductQTY']?></td>
                                <td><?=$Rows['UsedQty']?></td>
                                <td><?= $Rows['ProductQTY']-$Rows['UsedQty']?></td>
                                <td>
                                  <?php  if(in_array( $Gate['VIEW_SALE_BUTTON_IJ'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                                      <button class="btn btn-outline-primary fw-bold border-2" type="button" 
                                      onclick = "PutQTYToModal('<?=$Rows['CTNId']?>', '<?=$Rows['UsedQty']?>','<?=$Rows['ProductQTY']?>')" 
                                      data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Sale</button>
                                  <?php } ?> 
                                </td>
                            </tr>

                              <tr id = "details_tr_Title_<?=$Rows['CTNId']?>"  style = "display:none; color:#D09CFA;">
                                  <th></th> 
                                  <th></th>
                                  <th></th> 
                                  <th>#</th>
                                  <th>Cust Id</th>
                                  <th>Cust Name</th>
                                  <th>Sale Date</th>
                                  <th>Sale QTY</th>
                                  <th>Sale Price</th>
                                  <th>Total Price</th>
                                  <th>OPS</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  
                              </tr>
                            <?php 
                                  $Counter=1;
                                  $carton_sale=$Controller->QueryData('SELECT  `SaleId`, `SaleCustomerId`, `SaleCartonId`, `SaleQty`, `SaleCurrency`, `SalePrice`,SaleDate, `SaleTotalPrice`, `SaleComment`, ppcustomer.CustName  
                                  FROM cartonsales INNER JOIN carton ON carton.CTNId=cartonsales.SaleCartonId 
                                  INNER JOIN ppcustomer ON ppcustomer.CustId=cartonsales.SaleCustomerId WHERE SaleCartonId=?',[$Rows['CTNId']]); 
                                  while($CTN_Sale=$carton_sale->fetch_assoc()) { ?>
                                      <tr class = "details_tr_<?=$Rows['CTNId']?>" style = "display:none;"> 
                                        <td></td>
                                        <td></td>
                                        <td> </td>
                                        <td><?=$Counter?></td>
                                        <td><?=$CTN_Sale['SaleCustomerId']?></td>
                                        <td><?=$CTN_Sale['CustName']?> </td>
                                        <td><?=substr($CTN_Sale['SaleDate'], 0 , 16)?></td>
                                        <td><?=$CTN_Sale['SaleQty']?></td>
                                        <td><?=$CTN_Sale['SalePrice']?></td>
                                        <td><?=$CTN_Sale['SaleTotalPrice']?></td>
                                        <td>
                                            <?php  if(in_array( $Gate['VIEW_PRINT_BUTTON_IJ'] , $_SESSION['ACCESS_LIST']  )) { ?>
                                            <a href="InternalJobPrint.php?id=<?=$CTN_Sale['SaleId']?>">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                              </svg>
                                            </a>
                                            <?php } ?> 
                                        </td>
                                        <td> </td>
                                        <td> </td> 
                                        <td> </td> 
                                      </tr> 
                                    <?php $Counter++; }  ?>
               

                      <?php  $Count++;
                      }
                  ?>
                    
                </tbody>
            </table>
            <div class="d-md-flex justify-content-md-end me-5">
               
			</div>


		</form>
    </div><!-- End of table div -->
</div> <!-- End tag of card div -->
<!-- Start body of table Card -->
 
 

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <div class="d-flex justify-content-center">
        <h5 id="offcanvasRightLabel" class="pt-2">
          <svg width="35" height="35" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M300.138 105.931H247.172V88.276H158.896V105.931H34.869C15.36 105.931 0 121.741 0 141.241V476.69C0 496.19 15.36 512 34.869 512H370.759C390.259 512 406.069 496.19 406.069 476.69V211.862C347.569 211.862 300.138 164.431 300.138 105.931Z" fill="#C69666"></path>
            <path d="M234.221 201.5L203.033 176.553L171.845 201.5C166.628 205.675 158.895 201.959 158.895 195.277V88.278H247.171V195.277C247.171 201.959 239.438 205.676 234.221 201.5Z" fill="#E8D5B2"></path>
            <path d="M512 105.931C512 47.431 464.569 0 406.069 0C347.569 0 300.138 47.431 300.138 105.931C300.138 164.431 347.569 211.862 406.069 211.862C464.569 211.862 512 164.431 512 105.931Z" fill="#71C285"></path>
            <path d="M52.966 476.69H176.552V370.759H52.966V476.69Z" fill="#E8D5B2"></path>
            <path d="M141.241 414.897H88.276C83.403 414.897 79.448 410.942 79.448 406.069C79.448 401.196 83.403 397.241 88.276 397.241H141.242C146.115 397.241 150.07 401.196 150.07 406.069C150.07 410.942 146.114 414.897 141.241 414.897Z" fill="#CBB292"></path>
            <path d="M123.586 450.207H88.276C83.403 450.207 79.448 446.252 79.448 441.379C79.448 436.506 83.403 432.551 88.276 432.551H123.586C128.459 432.551 132.414 436.506 132.414 441.379C132.414 446.252 128.459 450.207 123.586 450.207Z" fill="#CBB292"></path>
            <path d="M319.32 119.48C322.377 121.056 327.084 122.624 331.942 122.624C337.169 122.624 339.94 120.453 339.94 117.166C339.94 114.022 337.553 112.228 331.498 110.064C323.138 107.147 317.678 102.511 317.678 95.183C317.678 86.5813 324.848 80 336.724 80C342.403 80 346.59 81.1911 349.573 82.5406L347.035 91.7378C345.016 90.7653 341.431 89.3556 336.506 89.3556C331.573 89.3556 329.178 91.5946 329.178 94.218C329.178 97.4296 332.017 98.8468 338.517 101.312C347.411 104.606 351.584 109.243 351.584 116.344C351.584 124.795 345.092 131.972 331.272 131.972C325.518 131.972 319.839 130.472 317 128.904L319.32 119.48Z" fill="white"></path>
            <path d="M405.379 105.496C405.379 122.021 395.378 132.04 380.662 132.04C365.72 132.04 356.976 120.747 356.976 106.393C356.976 91.293 366.608 80 381.475 80C396.944 80 405.379 91.587 405.379 105.496ZM369.003 106.174C369.003 116.043 373.635 122.993 381.257 122.993C388.946 122.993 393.352 115.658 393.352 105.873C393.352 96.8265 389.021 89.054 381.181 89.054C373.492 89.0465 369.003 96.3741 369.003 106.174Z" fill="white"></path>
            <path d="M412.873 80.8292H424.298V121.651H444.316V131.226H412.873V80.8292Z" fill="white"></path>
            <path d="M451.041 81.4926C455.229 80.8217 460.674 80.4448 466.435 80.4448C476 80.4448 482.19 82.1636 487.048 85.8274C492.275 89.7174 495.558 95.9218 495.558 104.825C495.558 114.467 492.049 121.124 487.199 125.232C481.897 129.65 473.831 131.738 463.965 131.738C458.068 131.738 453.88 131.361 451.041 130.992V81.4926ZM462.474 122.624C463.445 122.85 465.019 122.85 466.435 122.85C476.738 122.926 483.463 117.241 483.463 105.202C483.539 94.7307 477.408 89.1972 467.625 89.1972C465.087 89.1972 463.438 89.4234 462.466 89.6496V122.624H462.474V122.624Z" fill="white"></path>
          </svg>
          Sales Form
        </h5>
    </div>
   
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    
        <div class="form-floating mb-3" style="z-index: 20;">
          <input type="text" name = "CustomerName"  id = "customer" class="form-control" value = "<?php if(isset($CustomerName)) echo $CustomerName ;  ?>" 
                        onclick="HideLiveSearch();" onkeyup="AJAXSearch(this.value);" placeholder = "Search Company Names" autocomplete="off" require>
                        <div id="livesearch" class="list-group shadow z-index-2 position-absolute mt-2 w-25"></div>
                        
          <!-- <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"> -->
          <label for="floatingInput">Select Customer</label>
        </div>
    <form action="BGCartonSale.php" method="post">
        <input type="hidden" name="CustId" id = "CustId">
        <input type="hidden" name="CTNId" id="CTNId">
        <input type="hidden" name="ProId" id="ProId">
        <input type="hidden" name="ProOutQTY" id="ProOutQTY">
        <div class="form-floating mb-3">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="Currency">
              <!-- <option selected>Open this select menu</option> -->
              <option value="AFN">AFN</option>
              <option value="USA">USA</option> 
            </select>
            <label for="floatingSelect">Select Currency</label>
        </div>
      
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="AVLQTY" placeholder="" name="AVLQTY"
           readonly onchange="TakeValue(this.name, this.value);">
          <label for="floatingInput">Available QTY</label>
        </div>
       
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="SaleQTY" placeholder="" name="SaleQTY" onchange="TakeValue(this.name, this.value);">
          <label for="floatingInput">Sales QTY</label>
        </div>
   
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UnitePrice" placeholder="" name="UnitePrice" onchange="TakeValue(this.name, this.value);">
          <label for="floatingInput">Unit Price</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="TotalPrice" placeholder="name@example.com" name="TotalPrice">
          <label for="floatingInput">Total Price</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="Comments" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Comments</label>
        </div>

        <div class="text-end">
            <input type="submit" name="Save" value="Save" class="btn btn-outline-primary ">
        </div>

    </form>
   
  </div>
</div>
 
<script>

let RemainQTY= document.getElementById("ReminQTY").value;
document.getElementById("AVLQTY").value=RemainQTY;



let total = {}; 
function TakeValue(name , value) 
{
    total[name] = value; 
    CalculatePlates(total); 
}


function CalculatePlates(total)
{
  let TotalPrice =(Number(total.SaleQTY) * Number(total.UnitePrice));
  document.getElementById("TotalPrice").value=TotalPrice;
}



function PutQTYToModal(CTNID,  ProID,ProOutQTY )
{

  // // $Rows['ProductQTY']-$Rows['UsedQty']
    document.getElementById("CTNId").value=CTNID;
    document.getElementById("ProId").value=ProID;
    document.getElementById("ProOutQTY").value=ProOutQTY;
}

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


function search(InputId ,tableId )  {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(InputId);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId);
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) {
    td = tr[i];
    if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        } else {
        tr[i].style.display = "none";
        }
    }
    }
}

function PutSearchTermToInputBox(input) {
    document.getElementById('Search_input').value = input; 
    search('Search_input' ,'OrderTable');  
}



function submitMe(obj)
{
    if( allAreEqual(CustomerIdList) == false ){
        alert('You clicked two different Customer please Uncheck The Red Checkbox'); 
        return window.location.replace("CustomerOrderPage.php");
    }

	if(obj.value=="View"){
		document.getElementById('FORM').action='QuotationPage.php'
	}document.getElementById('FORM').submit();
}



function view_details(id)
{

 
    let tr = document.getElementsByClassName(id);
    console.log(tr);
    var header_id = id.match(/\d+/)[0];

 
   
    for (var i = 0; i < tr.length; i++) {
      if( tr.item(i).style.display == "") 
      {
        tr.item(i).style.display = 'none'; 
        document.getElementById('details_tr_Title_'+ header_id).style.display= "none"; 
      }
      else 
      {
        tr.item(i).style.display = ""; 
        document.getElementById('details_tr_Title_'+ header_id).style.display= "";
      }
    
    }




}



</script>


<?php  require_once '../App/partials/Footer.inc'; ?>




