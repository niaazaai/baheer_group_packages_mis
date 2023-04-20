<?php 
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc';  
require_once 'InternalFollowUpController.php';    
require_once '../Assets/Zebra/Zebra_Pagination.php';

    $pagination = new Zebra_Pagination();
    $RECORD_PER_PAGE = 15;
    $Query = "SELECT  carton.CTNId, JobNo ,CTNOrderDate , ProductName , CTNQTY ,   CustName  ,   CTNStatus,  ProQty , ProDate ,ProOutQty , ppcustomer.CustId ,  CustMobile , follow_result
    FROM carton
    INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
    INNER JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
    LEFT JOIN follow_up ON carton.CustId1  = follow_up.customer_id  GROUP BY JobNo ORDER BY CTNId DESC
    ";

    $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';
    

    $PaginateQuery= "SELECT COUNT(carton.CTNId) AS RowCount , JobNo
    FROM carton
    INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
    INNER JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
    LEFT JOIN follow_up ON carton.CustId1  = follow_up.customer_id  GROUP BY JobNo ORDER BY carton.CTNId DESC";
    $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
    $row = $RowCount->fetch_assoc(); 
    $pagination->records($RowCount->num_rows);
    $pagination->records_per_page($RECORD_PER_PAGE);


    if (isset($_POST['FieldType']) && isset($_POST['SearchTerm']) && !empty($_POST['FieldType']) && !empty($_POST['SearchTerm'])) {
        $FieldType = $Controller->CleanInput($_POST['FieldType']);
        $Term = $Controller->CleanInput($_POST['SearchTerm']);
        $FieldTypeTerm = "WHERE $FieldType LIKE LOWER('%$Term%')";
        $Query = "SELECT  carton.CTNId, JobNo ,CTNOrderDate , ProductName , CTNQTY ,   CustName  ,   CTNStatus,  ProQty , ProDate ,ProOutQty , ppcustomer.CustId ,  CustMobile , follow_result
            FROM carton
            INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
            INNER JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
            LEFT JOIN follow_up ON carton.CustId1  = follow_up.customer_id ". $FieldTypeTerm  ." GROUP BY JobNo ORDER BY CTNId DESC ";
    }// end of isset 

    $DataRows  = $Controller->QueryData( $Query, [] );
?>

<div class="m-3">
    <div class="card mb-3"   >
        <div class="card-body d-flex justify-content-between shadow">
            <h3 class="m-0 p-0"> Finished Goods List  <small style= "font-size:18px; color:#FA8b09;">   (Internal Follow Up) </small> </h3>
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

    <section class="card" id = "print_area"  >
            <div class="card-body table-responsive ">
                <div class = "mb-2" >
                    <a href = "index.php"  ><span class = "badge bg-info position-relative">Task List 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> 5+  </span>
                    </span></a>
                    <a href = "FinishedGoods.php" onclick = "PutSearchTermToInputBox('Urgent')"><span class = "badge bg-danger  ">Finish Goods</span></a>
                    <a href = "InternalFollowUp.php" onclick = "PutSearchTermToInputBox('')"><span class = "badge bg-dark  ">Job Process</span></a>
                </div>

                <table class="table  " id = "main-table"  >
                    <thead >
                        <tr >
                            <th>#</td> 
                            <th>Production Date </th> 
                            <th>Job No</th>     
                            <th>Customer Name </th> 
                            <th>Product Name</th> 
                            <th>Order Qty</th> 
                            <th>Produced Qty</th> 
                            <th> Delivered</th> 
                            <th>Remain Qty</th> 
                            <th>Days Passed</th> 
                            <th>Results</th> 
                            <th>Comment</th> 
                            <th>Follow Up </th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ; foreach ($DataRows as $IFCData)   :?>   
                            <!-- CTNId , JobNo ,CTNOrderDate , CTNFinishDate, ProductName,CTNColor , CTNQTY -->
                           <tr>
                            <td><?=$i++; ?></td> 
                            <td><?= $IFCData['ProDate']?></td> 
                            <td><?= $IFCData['JobNo']?></td>     
                            <td><?= $IFCData['CustName']?></td>  
                            <td><?= $IFCData['ProductName']?></td> 
                            <td><?=number_format($IFCData['CTNQTY']); ?></td> 
                            <td><?=number_format($IFCData['ProQty'] ); ?></td> 
                            <td><?=number_format($IFCData['ProOutQty']);?></td> 
                            <td><?php  echo number_format ($IFCData['ProQty'] - $IFCData['ProOutQty']  ); ?></td> 
                            <td>
                                <?php 
                                    $ProductionDate = date("Y-m-d", strtotime($IFCData['ProDate']));
                                    $Today = date("Y-m-d");
                                    $days = (strtotime($Today) - strtotime($ProductionDate)) / (60 * 60 * 24);
                                    print round($days); 
                                ?>
                            </td> 
                            <td><?=$IFCData['follow_result'];?></td> 
                            <td ></td> 
                            <td> 
                                <!-- <a class="btn btn-outline-primary "  title = "Click for Follow Up " style="font-weight:bold;" href="FollowUp.php?CustId=<?=$IFCData['CustId']?>&Product=<?=$IFCData['ProductName']?>"> FUP  </a> -->
                            </td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
    </section>
</div>
<div class="card ms-3 me-3">
    <div class="card-body d-flex justify-content-center">
        <?php  $pagination->render(); ?>
    </div>
</div>

<?php  require_once '../App/partials/Footer.inc'; ?>
