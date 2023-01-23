
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

    $Query =    "SELECT CTNId , CustName , JobNo , CTNOrderDate , CTNFinishDate , ProductName  , CTNQTY   , CusProvince  , ProQty , CTNStatus  
                FROM carton
                INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
                LEFT JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
                WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond'   ";
    $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';

    $PaginateQuery = "SELECT  COUNT(CTNId) AS RowCount
                FROM carton
                INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
                LEFT JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
                WHERE JobNo != 'NULL' && CTNStatus != 'Completed' && CTNStatus != 'Postpond'    ";

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

    <div class="card  mb-3" id = "page_title" >
        <div class="card-body d-flex justify-content-start">

            <a class= "btn btn-outline-primary  me-3 " href="FUP.php ">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>  
            <h3 class = "my-1" > Jobs Precess Status For (Internal Follow Up)  </h3>
        </div>
    </div>

    <div class="card "  >
        <div class="card-body">
                <div class = "row d-flex justify-content-between">
                    <div class="col-lg-4 col-md-4 col-sm-12">
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
                    <div class="col-lg-5 col-md-4 col-sm-12 d-flex justify-content-end  ">
                        <a href="Manual/ProductList_Manual.php"   class = "text-primary me-1  " title = "Click to Read the User Guide " >
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                            </svg>
                        </a>

                        <a href="FinishedGoods.php" class = " btn btn-outline-primary " >
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16">
                            <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            </svg>  Finished Goods
                        </a>
                    </div>
                </div>
            </div>
    </div>
        

    <div class="row mt-3"   >
        <div class="col-sm-12 col-lg-12 col-md-12">
            <section class="card" id = "print_area" >
                <div class="card-body table-responsive ">
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
                                <a class="text-primary btn btn-sm py-1 my-1" href="../Finance/JobCard.php?CTNId=<?=$IFCData['CTNId'];?>&ListType=InternalFollowUp" title="View Job Card">  
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="#20c997" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.68878 18.5713L6.42858 23.3111V18.5713H1.68878Z" fill="#20c997"></path>
                                        <path d="M15.3725 10.0308H14.3265V11.592H15.3725C15.9031 11.592 16.3367 11.2399 16.3367 10.8114C16.3367 10.3828 15.9031 10.0308 15.3725 10.0308Z" fill="#20c997"></path>
                                        <path d="M9.99489 11.5919C10.5105 11.5919 10.9286 10.6553 10.9286 9.50004C10.9286 8.34475 10.5105 7.4082 9.99489 7.4082C9.47924 7.4082 9.06122 8.34475 9.06122 9.50004C9.06122 10.6553 9.47924 11.5919 9.99489 11.5919Z" fill="#20c997"></path>
                                        <path d="M15.3725 7.41309H14.3265V8.97431H15.3725C15.9031 8.97431 16.3367 8.62227 16.3367 8.1937C16.3367 7.76002 15.9031 7.41309 15.3725 7.41309Z" fill="#20c997"></path>
                                        <path d="M0 0V17.1633H7.14286C7.52041 17.1633 7.83674 17.4796 7.83674 17.8571V25H25V0H0ZM6.68367 10.801C6.68367 11.8163 5.66327 12.6429 4.40816 12.6429C3.15306 12.6429 2.13265 11.8163 2.13265 10.801V10.7041C2.13265 10.4133 2.42347 10.1786 2.78061 10.1786C3.13776 10.1786 3.42857 10.4133 3.42857 10.7041V10.801C3.42857 11.2347 3.86735 11.5918 4.40306 11.5918C4.93878 11.5918 5.37755 11.2347 5.37755 10.801V6.88776C5.37755 6.59694 5.66837 6.36224 6.02551 6.36224C6.38265 6.36224 6.67347 6.59694 6.67347 6.88776V10.801H6.68367ZM9.9949 12.6429C8.7602 12.6429 7.7602 11.2347 7.7602 9.5C7.7602 7.76531 8.7602 6.35714 9.9949 6.35714C11.2296 6.35714 12.2296 7.76531 12.2296 9.5C12.2296 11.2347 11.2296 12.6429 9.9949 12.6429ZM17.6378 10.8112C17.6378 11.8214 16.6224 12.6429 15.3724 12.6429H13.6786C13.3214 12.6429 13.0306 12.4082 13.0306 12.1173V9.5051C13.0306 9.5051 13.0306 9.5051 13.0306 9.5C13.0306 9.5 13.0306 9.5 13.0306 9.4949V6.88776C13.0306 6.59694 13.3214 6.36224 13.6786 6.36224H15.3724C16.6224 6.36224 17.6378 7.18367 17.6378 8.19388C17.6378 8.70408 17.3776 9.16837 16.9541 9.5051C17.3776 9.83674 17.6378 10.301 17.6378 10.8112ZM20.6071 12.6429C19.9847 12.6429 19.3827 12.4337 18.9592 12.0663C18.7143 11.8571 18.7245 11.5204 18.9847 11.3214C19.2449 11.1224 19.6582 11.1327 19.9031 11.3418C20.0867 11.5 20.3367 11.5867 20.6071 11.5867C21.1378 11.5867 21.5714 11.2347 21.5714 10.8061C21.5714 10.3776 21.1378 10.0255 20.6071 10.0255C19.3571 10.0255 18.3418 9.20408 18.3418 8.18878C18.3418 7.17857 19.3571 6.35204 20.6071 6.35204C21.2296 6.35204 21.8316 6.56122 22.2551 6.92857C22.5 7.13776 22.4898 7.47449 22.2296 7.67347C21.9694 7.87245 21.5561 7.86225 21.3112 7.65306C21.1276 7.4949 20.8776 7.40816 20.6071 7.40816C20.0765 7.40816 19.6429 7.7602 19.6429 8.18878C19.6429 8.61735 20.0765 8.96939 20.6071 8.96939C21.8571 8.96939 22.8724 9.79082 22.8724 10.8061C22.8724 11.8214 21.852 12.6429 20.6071 12.6429Z" fill="#20c997"></path>
                                    </svg>
                                </a>  
                                
                                <a class="btn btn-outline-primary btn-sm" style="font-weight:bold;" href="PackageDetails.php?JobNo=<?=$IFCData['JobNo']?>">Details</a>

                                <a class="btn btn-outline-primary btn-sm" style="font-weight:bold;" href="PackageDetails.php?JobNo=<?=$IFCData['JobNo']?>">Track</a>
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
                </div>
            </section>
        </div>

</div> <!-- END OF DIV : margin-right:50px; margin-left:50px;  -->
<div class="card m-3 ">
    <div class="card-body d-flex justify-content-center">
        <?php  $pagination->render(); ?>
    </div>
</div>

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
