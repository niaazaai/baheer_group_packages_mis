 <!-- Starting area of back-end logic-->
 <?php require_once '../App/partials/Header.inc';  ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
  
<?php 
 
    $SQL="SELECT SaleId, SaleCustomerId,SaleCartonId,SaleQty, SaleCurrency, SalePrice,SaleTotalPrice,SaleComment,SaleUserId,SaleDate,carton.ProductName,JobNo,CustName, 
    CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size, CTNUnit
    FROM cartonsales INNER JOIN carton ON carton.CTNId=cartonsales.SaleCartonId INNER JOIN ppcustomer ON ppcustomer.CustId=cartonsales.SaleCustomerId ORDER BY SaleId DESC";
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
          BG Finished Goods <span style= "color:#FA8b09;" >   </span>
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
<!-- End of second Top Head Card which has dropdown and search functioanlity-->



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
                        <th>#</th>
                        <th>Date</th>
                        <th>Job #</th>
                        <th>Product Name</th>
                        <th>Size(LxWxH)cm</th>
                        <th>P.Type</th>
                        <th>Sale QTY</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Sold To</th> 
                        <th>OPS</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $Count=1;
                      while($Rows=$Data->fetch_assoc())
                      {  ?>
                             
                            <tr>
                                <td><?=$Count?></td>
                                <td><?=substr($Rows['SaleDate'], 0, 16)?></td>
                                <td><?=$Rows['JobNo'].'-'.$Rows['SaleId']?></td>
                                <td><?=$Rows['ProductName']?></td>
                                <td><?=$Rows['Size']?></td>
                                <td><?=$Rows['CTNUnit']?></td>
                                <td><?=$Rows['SaleQty']?></td>
                                <td><?=$Rows['SalePrice']?></td>
                                <td ><?=$Rows['SaleTotalPrice'].' <span class="badge bg-warning">'.$Rows['SaleCurrency'].'</span>'?></td>
                                <td><?=$Rows['CustName']?></td>
                                
                                <td>
                                   <a href="CustomerPayment.php?CTNId=<?=$Rows['SaleCartonId']?>&CustId=<?=$Rows['SaleCustomerId']?>" >
                                        <svg   width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M26.8376 20.9432L22.9139 15.4506C22.0493 14.2403 20.7554 13.4342 19.3544 13.2044C20.2643 11.822 20.7525 10.1965 20.7525 8.48336C20.7525 3.80562 17.0344 0 12.4642 0C7.89405 0 4.17595 3.80562 4.17595 8.48336C4.17595 10.122 4.63349 11.7127 5.49915 13.0832C6.25549 14.2807 7.28866 15.2587 8.50472 15.9361C8.72951 16.8677 9.54924 17.5669 10.5138 17.5888L15.4646 17.7014C15.5932 17.7044 15.674 17.7756 15.7107 17.8178C15.7474 17.86 15.8073 17.9504 15.7953 18.0815C15.7791 18.2593 15.631 18.3969 15.457 18.3969C15.4553 18.3969 15.4535 18.3969 15.4517 18.3969L9.76408 18.3065C9.45052 18.3015 9.14443 18.1865 8.90224 17.9825L3.86592 13.7422C2.90452 12.9327 1.48596 13.0282 0.636302 13.9594C0.204031 14.4333 -0.0213699 15.051 0.00159695 15.6988C0.0245638 16.3467 0.293203 16.946 0.758043 17.3865L7.16057 23.4537C7.95256 24.2041 8.9827 24.6377 10.0614 24.6746L19.5703 24.9995C19.5799 24.9998 19.5893 25 19.5989 25C20.051 25 20.425 24.6327 20.4402 24.1667C20.4557 23.6908 20.0914 23.2921 19.6265 23.2763L10.1176 22.9513C9.44367 22.9283 8.79992 22.6574 8.3051 22.1885L1.90262 16.1213C1.76903 15.9948 1.69182 15.8225 1.6852 15.6363C1.67857 15.4501 1.74337 15.2726 1.86764 15.1364C2.1118 14.8688 2.51953 14.8414 2.7958 15.0739L7.83212 19.3143C8.36776 19.7653 9.04464 20.0196 9.73797 20.0307L15.4256 20.121C15.4361 20.1212 15.4464 20.1213 15.4569 20.1213C16.4938 20.1212 17.3762 19.3014 17.4727 18.2415C17.5246 17.671 17.3409 17.0986 16.9685 16.6708C16.5962 16.2431 16.0617 15.9904 15.502 15.9777L10.5513 15.8651C10.3278 15.86 10.1422 15.6771 10.1288 15.4487C10.1191 15.2841 10.1966 15.1725 10.2436 15.1207C10.2906 15.0688 10.3936 14.9814 10.5546 14.979L18.463 14.8613C18.5034 14.8608 18.5437 14.8609 18.5837 14.8614C19.7375 14.8792 20.8479 15.4799 21.5541 16.4684L25.4777 21.9609C25.7523 22.3453 26.2793 22.4291 26.6548 22.148C27.0303 21.8669 27.1121 21.3276 26.8376 20.9432ZM10.5301 13.255C9.95472 13.2635 9.40026 13.516 9.00887 13.9477C8.95266 14.0097 8.90078 14.0751 8.85243 14.143C8.08059 13.6264 7.41978 12.9482 6.91389 12.1473C6.22477 11.0562 5.86056 9.78932 5.86056 8.48348C5.86056 4.75649 8.82295 1.72438 12.4642 1.72438C16.1055 1.72438 19.0679 4.75649 19.0679 8.48348C19.0679 10.2461 18.4197 11.8925 17.2361 13.1552L13.0256 13.2179V12.9048C14.1196 12.6437 14.9372 11.6381 14.9372 10.44C14.9372 9.24186 14.1196 8.23622 13.0256 7.97517V5.27049C13.4904 5.48907 13.8142 5.96979 13.8142 6.52667C13.8142 6.84405 14.0656 7.10143 14.3757 7.10143C14.6858 7.10143 14.9372 6.84405 14.9372 6.52667C14.9372 5.3286 14.1196 4.32295 13.0256 4.0619V3.66348C13.0256 3.3461 12.7742 3.08873 12.4641 3.08873C12.1539 3.08873 11.9025 3.3461 11.9025 3.66348V4.0619C10.8085 4.32295 9.99089 5.3286 9.99089 6.52667C9.99089 7.72475 10.8085 8.73033 11.9025 8.99145V11.6962C11.4377 11.4777 11.114 10.9969 11.114 10.44C11.114 10.1226 10.8626 9.86524 10.5524 9.86524C10.2423 9.86524 9.99089 10.1226 9.99089 10.44C9.99089 11.6381 10.8085 12.6437 11.9025 12.9048V13.2346L10.5301 13.255ZM11.9025 7.7828C11.4377 7.56427 11.114 7.08355 11.114 6.52661C11.114 5.96974 11.4377 5.48901 11.9025 5.27043V7.7828ZM13.0256 9.1837C13.4904 9.40228 13.8142 9.883 13.8142 10.4399C13.8142 10.9969 13.4904 11.4776 13.0256 11.6961V9.1837Z" fill="black"></path>
                                        </svg>
                                   </a>
                                 
                                  

                                </td>
                            </tr>
                      <?php
                          $Count++;
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

</script>


<?php  require_once '../App/partials/Footer.inc'; ?>




