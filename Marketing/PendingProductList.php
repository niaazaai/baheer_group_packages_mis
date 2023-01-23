<!-- 
    This page is linked with with Follow up page dashboard named (IndividualFollowUpPage.php).
    This is Pending Product List (PendingProductList.php) page, which is used fetch the records of those product which has status of InActive in table named carton.
    We have put setup functionality in this page which is made by ( Masiuallah Naizi ) Developer in Baheer group.
    *(Page Developed By-----------------------------------------------------------+> Furqan Ahmad Hajizada <+------------------------------------------------------------------)
 -->

<?php 
require_once '../App/partials/Header.inc';  
require_once '../App/partials/Menu/MarketingMenu.inc';
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
  



# THIS BLOCK WILL GET THE LIST TYPE WHICH GENERAL OR INDIVIDUAL 
if (filter_has_var(INPUT_GET, 'Type') ) {
    $Type = $Controller->CleanInput($_GET['Type']); 
  
    if($Type == 'General') {
     $Status = 'InActive';
     $ListTitle = "In Active";
    }
    elseif($Type == 'Individual') { 
     $Status = 'Pending';
     $ListTitle = "Pending";
    }
    else {
         die('<div class="alert alert-danger d-flex align-items-center m-3" role="alert">
             <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
                 <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z"/>
                 <path d="M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
             </svg>
             <div class = "ms-1  " > <strong>  Incorrect Type </strong>: This Incident Will be reported!   <a class= "  link " href="FUP.php">  Back  </a>     </div>
         </div>'); 
    }
  
  } # END OF IF BLOCK
  elseif(filter_has_var(INPUT_POST, 'Type') ){
   
    $Type = $Controller->CleanInput($_POST['Type']); 
  
    if($Type == 'General') {
       $Status = 'InActive';
       $ListTitle = "In Active";
    }
    elseif($Type == 'Individual') { 
       $Status = 'Pending';
       $ListTitle = "Pending";
    }
    else {
         die('<div class="alert alert-danger d-flex align-items-center m-3" role="alert">
             <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
                 <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z"/>
                 <path d="M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
             </svg>
             <div class = "ms-1  " > <strong>  Incorrect Type </strong>: This Incident Will be reported!   <a class= "  link " href="FUP.php">  Back  </a>     </div>
         </div>'); 
    }
  
  } 
  else {
     
     die('<div class="alert alert-danger d-flex align-items-center m-3" role="alert">
         <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
             <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z"/>
             <path d="M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
         </svg>
         <div class = "ms-1  " > <strong>  No Type Provided </strong>: This Incident Will be reported!   <a class= "  link " href="FUP.php">  Back  </a>     </div>
     </div>'); 
  
  }




  $RECORD_PER_PAGE = 5; 
  $DEFAULT_COLUMNS = "CTNId, CtnCurrency , ctnfollowup.AlarmDate,ppcustomer.CustName,ProductName, CONCAT(CTNLength,'X',CTNWidth,'X',CTNHeight) AS Size, carton.CTNPrice,employeet.Ename,carton.CTNStatus,ctnfollowup.FollowResult"; 
  $DEFAULT_TABLE_HEADING = '<th>#</th> <th>Alarm Date</th> <th>Company</th> <th>Product</th> <th>Size</th> <th>Unit Price</th>  <th>Quoted By</th> <th>Status</th> <th>Result</th>'; 
  $COLUMNS = ''; 
  $TABLE_HEADING = ''; 

    if (filter_has_var(INPUT_POST, 'SetColumns') )
    {

        if (in_array("200", $_POST)) $DEFAULT_COLUMNS .= ','; 
        foreach ($_POST as $key => $POST)
        {
            if ($POST === '200') {
                    if ($key === array_key_last($_POST))
                    {
                        $DEFAULT_COLUMNS .= $key ;
                        $TABLE_HEADING .= "<th> $key </th>";
                    } 
                    else
                    {
                        $DEFAULT_COLUMNS .= $key . ',';
                        $TABLE_HEADING .= "<th> $key </th>";
                    }
            }
        } # END OF LOOP

            $DEFAULT_TABLE_HEADING .= $TABLE_HEADING;
            $DEFAULT_TABLE_HEADING .= ' <th>OPS</th>' ;
      
            $Query="SELECT   $DEFAULT_COLUMNS  FROM carton  
            LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  
            LEFT JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
            WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery="SELECT COUNT(CTNId) AS RowCount  FROM carton  
            LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  
            LEFT JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
            WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 
        
            $pagination->records($RowCount->num_rows);
            $pagination->records_per_page($RECORD_PER_PAGE);
    }  
    else
    {
        $DEFAULT_TABLE_HEADING .= ' <th>OPS</th>' ;
        $Query="SELECT   $DEFAULT_COLUMNS  FROM carton 
        LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT JOIN employeet ON employeet.EId=carton.EmpId 
        LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
        WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows  = $Controller->QueryData($Query, []);

        $PaginateQuery="SELECT COUNT(CTNId) AS RowCount  FROM carton  
        LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  
        LEFT JOIN employeet ON employeet.EId=carton.EmpId 
        LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
        WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
        $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 
    
        $pagination->records($RowCount->num_rows);
        $pagination->records_per_page($RECORD_PER_PAGE);
    }

    if (filter_has_var(INPUT_POST, 'catagori') )
    {
        $CustomerName=$_POST['catagori'];
        if( $CustomerName == 'ALL') 
        {
            $Query="SELECT   $DEFAULT_COLUMNS  FROM carton 
            LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
            WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery="SELECT COUNT(CTNId) AS RowCount  FROM carton  
            LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  
            LEFT JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
            WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 
        
            $pagination->records($RowCount->num_rows);
            $pagination->records_per_page($RECORD_PER_PAGE);

        }
        else
        {
            $Query="SELECT   $DEFAULT_COLUMNS  FROM carton 
            LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            LEFT JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
            WHERE JobNo!='NULL' AND CTNStatus='$Status' AND CustName = ?  order by CTNId ASC";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, [$CustomerName]);

            $PaginateQuery="SELECT COUNT(CTNId) AS RowCount  FROM carton  
            LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  
            LEFT JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
            WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
            
            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 
        
            $pagination->records($RowCount->num_rows);
            $pagination->records_per_page($RECORD_PER_PAGE);

        }
    }
?>
<!-- Ending area of back-end logic -->

 
<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between ">
        <div class = "d-flex justify-content-start " >
        <a class= "btn btn-outline-primary  " href="IndividualFollowUpPage.php?Type=<?=$Type?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>     
        <h5 class = "m-0 ps-2 py-2 " > 
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                    <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                </svg>
                <?=$ListTitle ?> Product List  <span style= "color:#FA8b09;" > <?php if(isset($_POST['catagori'])) echo " - (".$_POST['catagori']." ) "; ?> </span>
            </h5>

        </div>
  
        <div class = "py-1" > <!--Button trigger modal div-->
        <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
				<path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
				<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
				<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
			</svg>
			</a>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
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
<div class="card mb-3  ms-3 me-3" style = "font-family: Roboto,sans-serif;"><!-- start of the card div -->
   <div class="card-body "> <!-- start of the card-body div -->
        <form action="" method="POST">
        <input type="hidden" name="Type" value = "<?=$Type ?>">
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">		
                    <select class="form-select  " name="catagori"  onchange="this.form.submit()">

				        <option>Select Catagory</option>
				        <option value = "ALL"> All </option><!--Basically the below php script is used to fetch the data of the customer (Customer Name) from to table in between catagory-->
                        <?php  
                                $CustomerNames  = $Controller->QueryData("SELECT DISTINCT carton.CustId1 ,ppcustomer.CustName 
                                FROM carton INNER JOIN  ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE CTNStatus='$Status' AND JobNo != 'NULL' ", []);
                                    foreach ($CustomerNames as $RowsKey => $Rows) 
                                    {
                        ?>
							            <option value="<?php echo $Rows['CustName']; ?>">
								            <?php echo $Rows['CustName']; ?>
							            </option>
				        <?php
                                	}
                        ?>
			        </select>
		        </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                    <input class="form-control " type="search" name="Search" id="Search" placeholder="SEARCH HERE...!" onkeyup="SearchFunction(this.id, 'myTable')">
                </div>
	        </div><!-- End Tag of div row -->
        </form> 
    </div> <!-- End of the card-body div -->
</div><!-- End of the card div -->
<!-- End of second Top Head Card which has dropdown and search functioanlity-->


<!-- Start body of table Card -->
<div class="card m-3"> <!-- Start tag of card div -->
    <div class="card-body table-responsive"><!-- start of table div -->
        <table class="table mt-5" id="myTable">
            <thead>
                <tr>
			        <?php if(isset($DEFAULT_TABLE_HEADING)) echo $DEFAULT_TABLE_HEADING ;  ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $counter = 1;  
                    foreach ($DataRows as $RowsKey => $Rows)
                    {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>"; 
                        foreach ($Rows as $key => $value) :?>
                            <?php if($key == 'CTNId' || $key == 'CtnCurrency') continue;  ?>
                           
                            <td Class = "<?php if($key == 'CTNPrice') echo 'text-end';  ?> "  >    <?=$value ?> 
                            <?php if($key == 'CTNPrice')  echo  '<span class="badge bg-warning">' .  $Rows['CtnCurrency']  .'</span>' ;  ?>
                            </td>
                        <?php endforeach;   ?> 
                        <td> 
                        <a class="text-primary m-1" href="" title="Edit">  
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>


                        <?php $FileAddress = pathinfo(__FILE__); ?>


                        <a class="text-primary m-1" href="FollowUpForm.php?id=<?= $Rows['CTNId'] ?>&Address=<?php echo $FileAddress['filename'] ?> " title="Follow Up" >  
                          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                          <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                          <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                          <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                          </svg>
                        </a>
                    </td>
                <?php
                         echo "</tr>";
                    }  # end of   loop
                
                ?>
            </tbody>
        </table>
    </div> <!-- End of table div -->
</div> <!-- End tag of card div -->
<!-- Start body of table Card -->
<div class="card m-3 ">
    <div class="card-body d-flex justify-content-center">
        <?php  $pagination->render(); ?>
    </div>
</div>

<script>
// This below SearchFunction is used for live search in table, but currently it does'nt worked because we have put setup in this page and for that reason a put some words on 
// the top of this code.
function SearchFunction(InputId, tableId) 
{
 	var input,filter,table,tr,td, txtValue, i;
	input=document.getElementById(InputId);
	filter=input.value.toLowerCase();
	table=document.getElementById(tableId);
	tr=table.getElementsByTagName("tr");
	for(i=0;i<tr.length;i++)
	{
		td=tr[i];
		if(td)
		{
			txtValue=td.textContent || td.innerText;
			if(txtValue.toLowerCase().indexOf(filter) > -1)
			{
				tr[i].style.display="";
			}
			else
			{
				tr[i].style.display="none";
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
        <h5 class="modal-title" id="staticBackdropLabel"><?=$ListTitle?> Product List Columns</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
        <input type="hidden" name="Type" value = "<?=$Type ?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <input type="hidden" name="SetColumns" value = "Okay">
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNOrderDate" > Order-Date</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNId"> Q.NO</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusProvince"> Province</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNColor"> Color</label> </div>
                                
                    </div><!-- END OF COL  -->
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNType"> Ply-Type</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNUnit"> Unit</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNTotalPrice" > Total-Amount</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "FollowComment" > Comment</label> </div>
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

<?php  require_once '../App/partials/Footer.inc'; ?>
 