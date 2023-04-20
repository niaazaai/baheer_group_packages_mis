
<?php    
require_once '../App/partials/Header.inc';   
require_once '../App/partials/Menu/MarketingMenu.inc'; 
require_once 'InternalFollowUpController.php'; 
?>  


<div class="m-3">

<?php
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 15;

    $Query = "SELECT CTNId , CustName , JobNo , CTNOrderDate , CTNFinishDate , ProductName  , CTNQTY   , CusProvince  , ProQty , CTNStatus  , ppcustomer.CustId
                FROM carton
                INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
                LEFT JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
                WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond'   ";
    $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';

    $PaginateQuery = "SELECT  COUNT(CTNId) AS RowCount
                FROM carton
                INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
                LEFT JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
                WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond' ";


    if (isset($_POST['FieldType']) && isset($_POST['SearchTerm']) && !empty($_POST['FieldType']) && !empty($_POST['SearchTerm'])) {
        $FieldType = $Controller->CleanInput($_POST['FieldType']);
        $Term = $Controller->CleanInput($_POST['SearchTerm']);
        $Query = "SELECT CTNId , CustName , JobNo , CTNOrderDate , CTNFinishDate , ProductName  , CTNQTY   , CusProvince  , ProQty , CTNStatus  
                    FROM carton
                    INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
                    LEFT JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
                    WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond' ";

        $FieldTypeTerm = "&& $FieldType LIKE LOWER('%$Term%')";
        $Query .= $FieldTypeTerm;
    }

    $DataRows  = $Controller->QueryData( $Query, [] );
    $pagination->records($RowCount->num_rows);
    $pagination->records_per_page($RECORD_PER_PAGE);
?>
    
     
    <div class="card"   >
        <div class="card-body d-flex justify-content-between shadow">
            <h3 class = "my-1" >  Jobs Process  </h3>

            <div>
                <a class="btn btn-outline-danger " data-bs-toggle="collapse" href="#colapse1" role="button" aria-expanded="false"  > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg> Search   
                </a>
                <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px; text-decoration:none;"  title="Click to Read the User Guide ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    

    <div class="collapse shadow" style="position: absolute; z-index: 1000; width: 60%; left: 39%; margin-top:-21px; " id="colapse1">
        <div class="card card-body border shadow">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                <div class="input-group  ">
                    <select class="form-select d-block" name="FieldType" style = "max-width: 40%;"   >
                        <option disabled >Select a Field </option>  
                        <option value = "JobNo" > Job Number </option>  
                        <option value = "ProductName" > Product Name </option>  
                        <option value = "CustName" >Customer Name</option>
                    </select>
                    <input type="text" name = "SearchTerm" id = "SearchTerm" aria-label="Write Search Term" class= "form-control"    >  
                    <button type="submit" class="btn btn-outline-primary">Find</button>
                </div>
            </form>
        </div>
    </div>
    
    
        

    <div class="row mt-3"   >
        <div class="col-sm-12 col-lg-12 col-md-12">
            <section class="card" id = "print_area" >
                <div class="card-body table-responsive ">

                <div class = "mb-2" >
                    <a href = "index.php"  ><span class = "badge bg-info position-relative">Task List 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> 5+  </span>
                    </span></a>
                    <a href = "FinishedGoods.php" onclick = "PutSearchTermToInputBox('Urgent')"><span class = "badge bg-danger  ">Finish Goods</span></a>
                    <a href = "InternalFollowUp.php" onclick = "PutSearchTermToInputBox('')"><span class = "badge bg-dark  ">Job Process</span></a>
                </div>


                <table class="table  " id = "main-table"  >
                    <thead class="table-info">
                        <tr>
                            <th>Job No</th>     
                            <th>Order Date</th> 
                            <th>Deadline</th> 
                            <th>Company</th> 
                            <th>Province</th> 
                            <th>Product Name</th> 
                            <th>Order Qty</th> 
                            <th>Produced Qty</th> 
                            <th>Status</th> 
                            <th>Reason</th>  
                            <th class="text-center">OPS</th>
                           
                        </tr>
                    </thead>
                    <tbody id = "main-table-tbody">

                        <?php   
                        if($DataRows->num_rows > 0 ) {
                        foreach ($DataRows as $IFCData) :  
                                $Carton_id = $IFCData['CTNId']; 
                                $DataRows  = $Controller->QueryData( "SELECT * FROM productionreport WHERE RepCartonId = ?", [$Carton_id] );
                                if ($DataRows->num_rows >  0) {

                                    // to recheck after job cycle completion  
                                    // if ($IFCData['CTNStatus']  == 'Completed' || $IFCData['CTNStatus'] =='Warehouse') {
                                    //     continue;
                                    // }
                                    $CartonData = $DataRows->fetch_assoc(); 
                                    switch ($IFCData['CTNStatus']) {
                                        case 'New':
                                            $Status = $IFC->FindCurrentStatus($CartonData['FinanceStart'], $CartonData['FinanceEnd'], 'Finance');
                                            break;
                                        case 'Fconfirm' || 'DesignProcess':
                                            $Status = $IFC->FindCurrentStatus($CartonData['DesignStart'], $CartonData['DesignEnd'], 'Design');
                                            break;
                                        case 'Printing':
                                            $Status = $IFC->FindCurrentStatus($CartonData['PPStart'], $CartonData['PPEnd'], 'Printing');
                                            break;
                                        case 'Archive':
                                            $Status = $IFC->FindCurrentStatus($CartonData['ArchiveStart'], $CartonData['ArchiveEnd'], 'Archive');
                                            break;
                                        case 'Production':
                                            $Status = $IFC->FindCurrentStatus($CartonData['ProductionStart'], $CartonData['ProductionEnd'], 'Production');
                                            break;
                                        case 'Warehouse':
                                            $Status = $IFC->FindCurrentStatus($CartonData['WarehouseStart'], $CartonData['WarehouseEnd'], 'Warehouse');
                                            break;
                                        case 'Completed':
                                            $Status = "<div style = 'text-align:center'> <Strong>Completed</Strong> </div>";
                                            break;
                                        case 'Cancel':
                                            $Status = "<div style = 'text-align:center'> <Strong>Cancel</Strong> </div>";
                                            break;
                                        default:
                                            $Status = "<div style = 'text-align:center'> <Strong>Unkown</Strong> </div>";
                                            break;
                                    }
                                } // END OF DATA ROWS NUM ROWS 
                                else $Status = $IFCData['CTNStatus'];
                            ?>
                           <tr>
                            <td><?= $IFCData['JobNo']?></td>     
                            <td><?= $IFCData['CTNOrderDate']?></td> 
                            <td><?= $IFCData['CTNFinishDate']?></td>  
                            <td><?= $IFCData['CustName']?></td> 
                            <td><?= $IFCData['CusProvince']?></td> 
                            <td><?= $IFCData['ProductName']?></td> 
                            <td><?= $IFCData['CTNQTY']?></td> 
                            <td><?= $IFCData['ProQty']?></td> 
                            <td><?=$Status  ?></td> 
                            <td></td> 
                            <td class="text-center">
                                <a  href="FollowUp.php?CustId=<?=$IFCData['CustId']?>&CTNId=<?=$IFCData['CTNId']?>&Product=<?=$IFCData['ProductName']?>&IFU=1qazxsw2cde3vfr4bgt5"   class="btn btn-outline-primary btn-sm" >Details</a>
                            </td> 
                           
                            </tr>
                        <?php endforeach; 
                        }
                        else {
                            echo "<tr><td colspan = '10' class = 'fw-bold text-center' > NO RECORD FOUND <td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                    <div class="mt-3 d-flex justify-content-center">
                        <?php  $pagination->render(); ?>
                    </div>
                </div>
            </section>
        </div>

</div> <!-- END OF DIV : margin-right:50px; margin-left:50px;  -->

<script>

    
function ShowCustomer(element) 	{
  var input, filter, table, tr, td, i, txtValue;
  input = element;
  filter = input.value.toLowerCase();
  table = document.getElementById("main-table-tbody");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[5];
      if (td){
          txtValue = td.textContent || td.innerText;
          if (txtValue.toLowerCase().indexOf(filter) > -1) 
          {
            tr[i].style.display = "";
          }
          else
          {
            tr[i].style.display = "none";
          }
      }       
  } // end of loop 
} // end of function 

 
</script>
 
</div>


<?php  require_once '../App/partials/Footer.inc'; ?>
