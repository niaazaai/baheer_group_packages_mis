<?php 
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc';  
require_once 'InternalFollowUpController.php';    
require_once '../Assets/Zebra/Zebra_Pagination.php';

    $pagination = new Zebra_Pagination();
    $RECORD_PER_PAGE = 15;
    $Query = "SELECT  CTNId, JobNo ,CTNOrderDate , ProductName , CTNQTY ,   CustName  ,   CTNStatus,  ProQty , ProDate ,ProOutQty , ppcustomer.CustId ,  CustMobile , follow_result
    FROM carton
    INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
    INNER JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
    LEFT JOIN follow_up ON carton.CustId1  = follow_up.customer_id  GROUP BY JobNo ORDER BY CTNId DESC
    ";

    $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';
    $DataRows  = $Controller->QueryData( $Query, [] );

    $PaginateQuery= "SELECT COUNT(CTNId) AS RowCount , JobNo
    FROM carton
    INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId 
    INNER JOIN cartonproduction ON carton.CTNId  = cartonproduction.CtnId1
    LEFT JOIN follow_up ON carton.CustId1  = follow_up.customer_id  GROUP BY JobNo ORDER BY CTNId DESC";
    $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
    $row = $RowCount->fetch_assoc(); 
    $pagination->records($RowCount->num_rows);
    $pagination->records_per_page($RECORD_PER_PAGE);

?>

<div class="m-3">
<div class="card  mb-3">
    <div class="card-body d-flex justify-content-between">
        <div class="d-flex justify-content-start">
            <h3 style = " "> 
                <a class= "btn btn-outline-primary  " href="InternalFollowUp.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg> 
                </a>  
                Finished Goods List  <small style= "font-size:18px; color:#FA8b09;">   (Internal Follow Up) </small>   
            </h3>
        </div>
        <div class="py-1">
            <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                </svg>
                </a>
        </div>
        
    </div>
</div>
    <section class="card" id = "print_area"  >
            <div class="card-body table-responsive ">
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
                                <a class="btn btn-outline-primary "  title = "Click for Follow Up " style="font-weight:bold;" href="FollowUp.php?CustId=<?=$IFCData['CustId']?>&Product=<?=$IFCData['ProductName']?>"> FUP  </a>
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
