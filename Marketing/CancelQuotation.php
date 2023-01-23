 

 <!-- Starting area of back-end logic-->
<?php require_once '../App/partials/Header.inc'; ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
 
<?php 
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 15;

  $DEFAULT_COLUMNS = 'CTNId, JobNo,CTNOrderDate,Canceldate,ppcustomer.CustName, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size  ,ProductName,CTNQTY,CtnCurrency ,CTNPrice,employeet.Ename,CancelComment '; 
  $DEFAULT_TABLE_HEADING = '<th>#</th><th>Job-#</th> <th>Q-Date</th> <th>Cancel-Date</th> <th>Company</th> <th>Size(LxWxH) cm</th> <th>Product</th> <th>Order Qty</th> <th>Unit Price</th> <th>Cancel-By</th> <th>Reason</th>  '; 
  $COLUMNS = ''; 
  $TABLE_HEADING = ''; 

    if (filter_has_var(INPUT_POST, 'SetColumns') )
    {

        if (in_array("200", $_POST)) $DEFAULT_COLUMNS .= ','; 
        foreach ($_POST as $key => $POST) {
            if ($POST === '200')  {
                    if ($key === array_key_last($_POST)) {
                        $DEFAULT_COLUMNS .= $key ;
                        $TABLE_HEADING .= "<th> $key </th>";
                    } 
                    else {
                        $DEFAULT_COLUMNS .= $key . ',';
                        $TABLE_HEADING .= "<th> $key </th>";
                    }
            }
        } # END OF LOOP
            $DEFAULT_TABLE_HEADING .= $TABLE_HEADING;
            $DEFAULT_TABLE_HEADING .= '<th>OPS</th>' ;
            $Query="SELECT DISTINCT $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId  WHERE  CTNStatus='Cancel' order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery ="SELECT DISTINCT COUNT(CTNId) AS RowCount
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId  WHERE  CTNStatus='Cancel' order by CTNId ASC";

            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 

            $pagination->records($row['RowCount']); 
            $pagination->records_per_page($RECORD_PER_PAGE);

    }  # END OF IF 
    else
    {
        $DEFAULT_TABLE_HEADING .= '<th>OPS</th>' ;
        $Query="SELECT DISTINCT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN employeet ON employeet.EId=carton.EmpId  where  CTNStatus='Cancel' order by CTNId DESC";
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows = $Controller->QueryData($Query, []);

        $PaginateQuery ="SELECT DISTINCT COUNT(CTNId) AS RowCount
        FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN employeet ON employeet.EId=carton.EmpId  where  CTNStatus='Cancel' order by CTNId ASC";

        $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 

        $pagination->records($row['RowCount']);
        $pagination->records_per_page($RECORD_PER_PAGE);
    } # END OF ELSE

    if (filter_has_var(INPUT_POST, 'catagori') )
    {
        $CustomerName=$_POST['catagori'];
        if( $CustomerName == 'ALL') 
        {
            $Query="SELECT DISTINCT $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId  where  CTNStatus='Cancel' order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery ="SELECT DISTINCT  COUNT(CTNId) AS RowCount
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId  where  CTNStatus='Cancel' order by CTNId ASC";

            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 

            $pagination->records($row['RowCount']);
            $pagination->records_per_page($RECORD_PER_PAGE);
        }
        else
        {
            $Query="SELECT DISTINCT $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId
            where  CTNStatus='Cancel' &&  ppcustomer.CustName = ? order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, [$CustomerName]);

            $PaginateQuery ="SELECT DISTINCT  COUNT(CTNId) AS RowCount
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId  where  CTNStatus='Cancel' order by CTNId ASC";

            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 

            $pagination->records($row['RowCount']);
            $pagination->records_per_page($RECORD_PER_PAGE);
        }
    } # END OF IF

    if (filter_has_var(INPUT_POST, 'FieldType')  && filter_has_var(INPUT_POST, 'SearchTerm') ) {
        if(!empty($_POST['FieldType']) &&  !empty($_POST['SearchTerm'])  ) {
          $FieldType = $Controller->CleanInput($_POST['FieldType']);
          $SearchTerm = $Controller->CleanInput($_POST['SearchTerm']);
          
          $DEFAULT_COLUMNS1 = 'CTNId, JobNo, CTNOrderDate, Canceldate, CustName, CONCAT( CTNWidth, " x ", CTNHeight , " x " , CTNLength ) AS Size, ProductName, CTNQTY, CtnCurrency , CTNPrice,Ename,CancelComment '; 
          $DEFAULT_TABLE_HEADING = '<th>#</th><th>Job-#</th> <th>Q-Date</th> <th>Cancel Date</th> <th>Company</th> <th>Size(LxWxH)</th> <th>Product</th> <th>Order Qty</th> <th>Unit Price</th> <th>Cancel By</th> <th>Reason</th>  '; 
          $EmployeetJoin = 'INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId LEFT JOIN employeet ON employeet.EId = carton.EmpId   ';  
          $DEFAULT_TABLE_HEADING .= '<th> OPS</th>';
          $DataRows = $Controller->QueryData("SELECT $DEFAULT_COLUMNS1 FROM carton $EmployeetJoin WHERE $FieldType  LIKE LOWER('%$SearchTerm%') LIMIT  100" , []);

        } # END FieldType SearchTerm 
      } # END SEARCH BLOCK 
?>
<!-- Ending area of back-end logic -->
 


 
<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class= "btn btn-outline-primary  p-1" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
            </a>

            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
            </svg>
            Cancel Order List <span style= "color:#FA8b09;"> <?php if(isset($_POST['catagori']))  echo " - ( " . $_POST['catagori'] . " Company )"?> </span>
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <button type="button" class="btn btn-outline-primary  " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
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
<div class="card m-3" style = "font-family: Roboto,sans-serif;"> <!-- start of the card div -->
   <div class="card-body "><!-- start of the card-body div -->
        <form action="" method="POST">
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">		

                    <select class="form-select  my-1" name="catagori"  onchange="this.form.submit()">
				        <option>Select Catagory</option>
				        <option value = "ALL"> All </option><!--Basically the below php script is used to fetch the data of the customer (Customer Name) from to table in between catagory-->
                        <?php    $CustomerNames  = $Controller->QueryData("SELECT DISTINCT carton.CustId1 ,ppcustomer.CustName FROM carton INNER JOIN  ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE CTNStatus='Cancel'", []);
                                    foreach ($CustomerNames as $RowsKey => $Rows) :
                        ?>
							            <option value="<?php echo $Rows['CustName']; ?>">
								            <?php echo $Rows['CustName']; ?>
							            </option>
				        <?php endforeach;  ?>
			        </select>
		        </div>
                <div class="col-lg-8 col-md-8  col-sm-12 col-xs-12 my-1 ">
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                      <div class="input-group" >
                            <select class="form-select d-block " style = " max-width: 30%;"   name="FieldType"   >
                                <option disabled >Select a Field </option>
                                <option value="CTNId"> Quot Number</option>
                                <option value="JobNo"> Job Number </option>
                                <option value="ProductName"> Product Name  </option>
                                <option value="CustName"> Company Name </option>
                            </select>
                            <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                            <button type="submit" class="btn btn-outline-primary">Find</button>
                      </div>
                    </form>
                </div> <!-- END OF COL  -->
                 
	        </div><!-- End Tag of div row -->
        </form>
    </div> <!-- End of the card-body div -->
</div><!-- End of the card div -->
<!-- End of second Top Head Card which has dropdown and search functioanlity-->


<!-- Start body of table Card -->
<div class="card m-3"> <!-- Start tag of card div -->
    <div class="card-body table-responsive  "><!-- start of table div -->
        <table class="table" id="CancelTable">
            <thead class="table-info">
                <tr>
			        <?php if(isset($DEFAULT_TABLE_HEADING)) echo $DEFAULT_TABLE_HEADING ;  ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $counter=1;
                    foreach ($DataRows as $RowsKey => $Rows)
                    {
                        echo "<tr>";
                        echo "<td>".$counter."</td>";
                        foreach ($Rows as $key => $value) :?>
                        <?php  if($key == 'CtnCurrency' || $key == 'CTNId') continue;   ?>

                        <td  <?php echo ($key  == 'CTNStatus') ?  ( ($value == "Cancel") ? 'class = "bg-danger text-white fw-bold text-center align-middle"': ''  ) : ''; ?> style = "<?php if($key == "CTNPrice") echo "text-align:right;" ?> " >    
 
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
                                    else 
                                    {

                                        print $value; 
                                    }
                                ?>
 
                        </td>
                        <?php endforeach; ?> 
                        <td>
                            <a class="text-primary m-1" href="CancelQJobCard.php?CTNId=<?=$Rows['CTNId']; ?> " title="View Job Card">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="#20c997" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.68878 18.5713L6.42858 23.3111V18.5713H1.68878Z" fill="#20c997"></path>
                                <path d="M15.3725 10.0308H14.3265V11.592H15.3725C15.9031 11.592 16.3367 11.2399 16.3367 10.8114C16.3367 10.3828 15.9031 10.0308 15.3725 10.0308Z" fill="#20c997"></path>
                                <path d="M9.99489 11.5919C10.5105 11.5919 10.9286 10.6553 10.9286 9.50004C10.9286 8.34475 10.5105 7.4082 9.99489 7.4082C9.47924 7.4082 9.06122 8.34475 9.06122 9.50004C9.06122 10.6553 9.47924 11.5919 9.99489 11.5919Z" fill="#20c997"></path>
                                <path d="M15.3725 7.41309H14.3265V8.97431H15.3725C15.9031 8.97431 16.3367 8.62227 16.3367 8.1937C16.3367 7.76002 15.9031 7.41309 15.3725 7.41309Z" fill="#20c997"></path>
                                <path d="M0 0V17.1633H7.14286C7.52041 17.1633 7.83674 17.4796 7.83674 17.8571V25H25V0H0ZM6.68367 10.801C6.68367 11.8163 5.66327 12.6429 4.40816 12.6429C3.15306 12.6429 2.13265 11.8163 2.13265 10.801V10.7041C2.13265 10.4133 2.42347 10.1786 2.78061 10.1786C3.13776 10.1786 3.42857 10.4133 3.42857 10.7041V10.801C3.42857 11.2347 3.86735 11.5918 4.40306 11.5918C4.93878 11.5918 5.37755 11.2347 5.37755 10.801V6.88776C5.37755 6.59694 5.66837 6.36224 6.02551 6.36224C6.38265 6.36224 6.67347 6.59694 6.67347 6.88776V10.801H6.68367ZM9.9949 12.6429C8.7602 12.6429 7.7602 11.2347 7.7602 9.5C7.7602 7.76531 8.7602 6.35714 9.9949 6.35714C11.2296 6.35714 12.2296 7.76531 12.2296 9.5C12.2296 11.2347 11.2296 12.6429 9.9949 12.6429ZM17.6378 10.8112C17.6378 11.8214 16.6224 12.6429 15.3724 12.6429H13.6786C13.3214 12.6429 13.0306 12.4082 13.0306 12.1173V9.5051C13.0306 9.5051 13.0306 9.5051 13.0306 9.5C13.0306 9.5 13.0306 9.5 13.0306 9.4949V6.88776C13.0306 6.59694 13.3214 6.36224 13.6786 6.36224H15.3724C16.6224 6.36224 17.6378 7.18367 17.6378 8.19388C17.6378 8.70408 17.3776 9.16837 16.9541 9.5051C17.3776 9.83674 17.6378 10.301 17.6378 10.8112ZM20.6071 12.6429C19.9847 12.6429 19.3827 12.4337 18.9592 12.0663C18.7143 11.8571 18.7245 11.5204 18.9847 11.3214C19.2449 11.1224 19.6582 11.1327 19.9031 11.3418C20.0867 11.5 20.3367 11.5867 20.6071 11.5867C21.1378 11.5867 21.5714 11.2347 21.5714 10.8061C21.5714 10.3776 21.1378 10.0255 20.6071 10.0255C19.3571 10.0255 18.3418 9.20408 18.3418 8.18878C18.3418 7.17857 19.3571 6.35204 20.6071 6.35204C21.2296 6.35204 21.8316 6.56122 22.2551 6.92857C22.5 7.13776 22.4898 7.47449 22.2296 7.67347C21.9694 7.87245 21.5561 7.86225 21.3112 7.65306C21.1276 7.4949 20.8776 7.40816 20.6071 7.40816C20.0765 7.40816 19.6429 7.7602 19.6429 8.18878C19.6429 8.61735 20.0765 8.96939 20.6071 8.96939C21.8571 8.96939 22.8724 9.79082 22.8724 10.8061C22.8724 11.8214 21.852 12.6429 20.6071 12.6429Z" fill="#20c997"></path>
                            </svg>
                            </a>
                            <a class="text-primary m-1" href="QuotationEdit.php?Page=CancelQuotation&CTNId=<?=$Rows['CTNId']; ?> " title="Edit">  
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                            </a>

                        </td>
                <?php
                         echo "</tr>";
                         $counter++;
                    }  # end of   loop  ?>
            </tbody>
        </table>
    </div><!-- End of table div -->
</div> <!-- End tag of card div -->
<!-- Start body of table Card -->

<div class="card ms-3 me-3">
    <div class="card-body d-flex justify-content-center">
        <?php  $pagination->render(); ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"><!-- Start of the model div -->
  <div class="modal-dialog modal-md"> <!-- Start of the model-dialog div -->
    <div class="modal-content">  <!-- Start of the model-content div -->
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cancel Order List Columns</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="hidden" name="SetColumns" value = "Okay">
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNId" > Quotation-No</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusProvince"> Province</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNColor"> Color</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CtnCurrency" > Currency</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNTotalPrice" > Total-Amount</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNStatus" > Status</label> </div>
                    </div><!-- END OF COL   -->
                </div><!-- END OF ROW  -->
                <table class = "table "  id = "SetColumnTable"></table>
            </div><!-- END OF MODAL BODY  -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button  class="btn btn-primary"  type="submit" name="SetColumns" >Set Columns</button>
            </div>
        </form>
    </div> <!-- End of the model-content div -->
  </div>  <!-- End of the model-dialog div -->
</div><!-- End of the model div -->





<script>
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




<?php  require_once '../App/partials/Footer.inc'; ?>

<!-- From my side it's done -->

