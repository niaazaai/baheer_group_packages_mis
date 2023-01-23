 <!-- Starting area of back-end logic-->
<?php require_once '../App/partials/Header.inc';  ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
 
<?php 
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 15;

  $DEFAULT_COLUMNS = 'CTNId,CustId,CTNOrderDate,ppcustomer.CustName,ProductName,CTNQTY,CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,CTNPrice,CTNTotalPrice,CTNStatus,employeet.Ename,CtnCurrency'; 
  $DEFAULT_TABLE_HEADING = '<th>#</th><th>Q-No</th><th>Order Date</th><th>Company</th><th>Product</th><th>Order-Qty</th><th>Size(LxWxH) cm</th><th>Unit Price</th><th>Total Amount</th><th>Status</th><th>Quoted By</th>'; 
  $COLUMNS = ''; 
  $TABLE_HEADING = ''; 

    if (filter_has_var(INPUT_POST, 'SetColumns') )
    {
        foreach ($_POST as $key => $POST)
        {
            if ($POST === '200')
            {
                    if ($key === array_key_last($_POST))
                    {
                        $COLUMNS .= $key ;
                        $TABLE_HEADING .= "<th> $key </th>";
                    } 
                    else
                    {
                        $COLUMNS .= $key . ',';
                        $TABLE_HEADING .= "<th> $key </th>";
                    }
            }
        } # END OF LOOP

            $DEFAULT_COLUMNS .= ',' . $COLUMNS; 
            $DEFAULT_TABLE_HEADING .= $TABLE_HEADING;
            $DEFAULT_TABLE_HEADING .= '<th>OPS</th>' ;
            $Query="SELECT DISTINCT $DEFAULT_COLUMNS
           	FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId  where JobNo='NULL' AND CTNStatus ='order'   order by CTNId DESC "; 
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery="SELECT DISTINCT  COUNT(CTNId) AS RowCount
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId  where JobNo='NULL'  AND CTNStatus ='order'   order by CTNId DESC "; 
            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 
        
            $pagination->records($row['RowCount']);
            $pagination->records_per_page($RECORD_PER_PAGE);
    }  
    else
    {
        $DEFAULT_TABLE_HEADING .= ' <th>OPS</th>' ;
        $Query="SELECT DISTINCT $DEFAULT_COLUMNS
        FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId  where JobNo='NULL' AND CTNStatus ='order'   order by CTNId DESC";
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows  = $Controller->QueryData($Query, []);

        $PaginateQuery="SELECT DISTINCT COUNT(CTNId) AS RowCount
        FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId  where JobNo='NULL' AND CTNStatus ='order'   order by CTNId DESC";
        $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 
    
        $pagination->records($row['RowCount']);
        $pagination->records_per_page($RECORD_PER_PAGE);
    }

    if (filter_has_var(INPUT_POST, 'catagori') )
    {
        $CustomerName=$_POST['catagori'];
        if( $CustomerName == 'ALL') 
        {
            $Query="SELECT DISTINCT $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId  where JobNo='NULL' AND CTNStatus ='order'  order by CTNId DESC ";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery="SELECT DISTINCT COUNT(CTNId) AS RowCount
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId  where JobNo='NULL' AND CTNStatus ='order'  order by CTNId DESC ";

            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 

            $pagination->records($row['RowCount']);
            $pagination->records_per_page($RECORD_PER_PAGE);

        }
        else
        {
            $Query="SELECT DISTINCT $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId
            where CTNStatus='order'  AND ppcustomer.CustName = ? order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, [$CustomerName]);

            $PaginateQuery="SELECT DISTINCT COUNT(CTNId) AS RowCount
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT OUTER JOIN employeet ON employeet.EId=carton.EmpId
            where CTNStatus='order'  AND ppcustomer.CustName = ? order by CTNId DESC";

            $RowCount =  $Controller->QueryData( $PaginateQuery ,[$CustomerName]  );
            $row = $RowCount->fetch_assoc(); 

            $pagination->records($row['RowCount']);
            $pagination->records_per_page($RECORD_PER_PAGE);

        }
    }

    $FileAddress = pathinfo(__FILE__);  
?>
<!-- Ending area of back-end logic -->


<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class= "btn btn-outline-primary btn-sm " href="index.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>     

            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                    <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
            </svg>
            Customer Order List <span style= "color:#FA8b09;" >   </span>
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
              </svg>
              Setup
            </button>
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 
 
 

<!-- Start of second Top Head Card which has dropdown and search functioanlity-->
<div class="card m-3"> <!-- start of the card div -->
   <div class="card-body "><!-- start of the card-body div -->
        <form action="" method="POST">
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">		

                    <select class="form-select  my-1" name="catagori"  onchange="this.form.submit()">
				        <option>Select Catagory</option>
				        <option value = "ALL"> All </option><!--Basically the below php script is used to fetch the data of the customer (Customer Name) from to table in between catagory-->
                        <?php   $CustomerNames  = $Controller->QueryData("SELECT DISTINCT carton.CustId1 ,ppcustomer.CustName FROM carton INNER JOIN  ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE  CTNStatus='Order'", []);
                                    foreach ($CustomerNames as $RowsKey => $Rows) { ?>

							            <option value="<?php echo $Rows['CustName']; ?>">
								            <?php echo $Rows['CustName']; ?>
							            </option>
				        <?php  }   ?>
			        </select>
		        </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 "> <!-- starting tag of div search -->
                    <input type="text" class= "form-control my-1" id = "Search_input" placeholder = "Search Orders Here"  onkeyup="search( this.id , 'OrderTable' )" >  
                </div> <!-- Ending tag of div search -->
	        </div><!-- End Tag of div row -->
        </form>
    </div> <!-- End of the card-body div -->
</div><!-- End of the card div -->
<!-- End of second Top Head Card which has dropdown and search functioanlity-->



<!-- Start body of table Card -->
<div class="card m-3"> <!-- Start tag of card div -->
    <div class="card-body table-responsive   "><!-- start of table div -->
    <form action="" id="FORM" method="POST">
        <input type="hidden" name="Address" value = "<?= $FileAddress['filename']?>" >
        <input type="hidden" name="CustId" id = "InputCustId" value = "" > 
        <table class="table " id="OrderTable">
            <thead class="table-info"><tr> <?php if(isset($DEFAULT_TABLE_HEADING)) echo $DEFAULT_TABLE_HEADING ;  ?></tr> </thead>
            <tbody>
                <?php  $counter = 1; 
                    foreach ($DataRows as $RowsKey => $Rows)
                    {
                        echo "<tr>";
                        echo "<td>".$counter."</td>";
                        foreach ($Rows as $key => $value) : ?>
                          <?php if($key == 'CustId'  || $key == 'CtnCurrency' ) continue;  ?>
                            <td>    
                                <?php 
                                        if($key == 'CTNQTY')
                                        {
                                            echo  number_format( $value);
                                        }
                                        elseif($key == 'CTNPrice') 
                                        {   
                                            if($Rows['CtnCurrency']=='AFN')
                                            {
                                                echo  number_format( $value, 2 ) .  " <span class='badge bg-warning'>".   $Rows['CtnCurrency'] ." </span>"; 
                                            } 
                                            elseif($Rows['CtnCurrency']=='USD')
                                            {
                                                echo  number_format( $value, 3 ) .  " <span class='badge bg-warning'>".   $Rows['CtnCurrency'] ." </span>"; 
                                            }
                                        
                                        }
                                        else if($key == 'CTNOrderDate') {
                                            $datetime1 = date_create($value);
                                            $datetime2 = date_create(date('Y-m-d'));
                                            $interval = date_diff( $datetime2 ,$datetime1 );
                                            echo  '<span class ="badge bg-info">' . $interval->format('%R%a days') . '</span>';


                                        }
                                        elseif($key=='CTNTotalPrice')
                                        {
                                            echo  number_format( $value );
                                        }
                                        else 
                                        {
                                            print $value; 
                                        }
                                    ?>
                            </td>
                        <?php endforeach;   ?> 

                        <td> 
                           
                            <input type="checkbox"  class = "form-check-input fs-4 p-0 m-0" id="design_<?=$counter?>"  
                            value="<?=  $Rows['CTNId'] ?>" name="design[]" 
                            title = "Click to View Design"  onclick='SetCustomerId(<?=$Rows["CustId"]?> , "design_<?=$counter?>" )'>
                           
					
							<a class="text-primary Py-1 my-1 p-0 m-0" href="QuotationEdit.php?Page=CustomerOrderPage&CTNId=<?=$Rows['CTNId'];?>  " title="Edit Quotation">  
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                	<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                	<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
						</td>
                <?php  $counter++; echo "</tr>";  }  # end of   loop  ?>
            </tbody>
			
            </table>
            <div class="d-md-flex justify-content-md-end me-5">
            <input class="btn btn-outline-primary  me-md-2  btn-sm" onclick="submitMe(this)" name="ViewButton" value="View">
			</div>


		</form>
    </div><!-- End of table div -->
</div> <!-- End tag of card div -->
<!-- Start body of table Card -->
<div class="card ms-3 me-3">
    <div class="card-body d-flex justify-content-center">
        <?php  $pagination->render(); ?>
    </div>
</div>

<script>
function submitMe(obj)
{
	if(obj.value=="View")
	{
		document.getElementById('FORM').action='QuotationPage.php'
	}
	document.getElementById('FORM').submit();
}

function search(InputId ,tableId ) {
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

</script>
<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Pending Quotation List Columns</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
            <div class="modal-body">
                <div class="row">
                    <div class="col ">
                                <input type="hidden" name="SetColumns" value = "Okay">
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "JobNo" > Job No</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusProvince"> Province</label> </div>
								<div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNColor"> Color</label> </div>
								<div class="checkbox"><label> <input type="checkbox" value="200" name = "CtnCurrency" > Currency</label> </div>
								<div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNFinishDate" > DeadLine</label> </div>
                    </div><!-- END OF COL   -->
                </div><!-- END OF ROW  -->
                <table class = "table "  id = "SetColumnTable"></table>
            </div><!-- END OF MODAL BODY  -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button  class="btn btn-primary"  type="submit" name="SetColumns" >Set Columns</button>
            </div>
        </form>
    </div>
  </div>
</div>


<script>
    
let CustomerIdList = []; 
function SetCustomerId(CustomerId , CheckboxId){
    var checkBox = document.getElementById(CheckboxId);

    // If the checkbox is checked, display the output text
    if (checkBox.checked == true){
        document.getElementById('InputCustId').value = CustomerId ;
        CustomerIdList.push(CustomerId);
       
        if( allAreEqual(CustomerIdList) == false ){
            alert('You clicked two different Customer please Uncheck The Last Customer '); 
            checkBox.style = 'background-color:red;'
        }
    } else  CustomerIdList.pop(CustomerId);
}

function allAreEqual(array) {
  const result = array.every(element => {
    if (element === array[0]) {
      return true;
    }
  });
  return result;
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


