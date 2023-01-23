<!-- 

This is pending quotation list which is linked with the follow up dashboard the dashboard file named (IndividualFollowUpPage.php).
In here only the data of those customer will be listed which are only inactive but due to the changes from high autority these page status shuld change from InActive to Pending.
We have put setup functionality in this page which is made by ( Masiuallah Naizi ) Developer in Baheer group.
   *(Page Developed By-----------------------------------------------------------+> Furqan Ahmad Hajizada <+------------------------------------------------------------------)*

 -->

 <!-- Starting area of back-end logic-->
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


  $DEFAULT_COLUMNS = " CtnCurrency , carton.CTNId , ctnfollowup.AlarmDate, ppcustomer.CustName,ProductName, CONCAT(CTNLength,'X',CTNWidth,'X',CTNHeight) AS Size,  carton.CTNQTY,carton.CTNPrice,  Ename , carton.CTNStatus,ctnfollowup.FollowResult";
  $DEFAULT_TABLE_HEADING = '<th>#</th> <th>Q-No</th>  <th>Alarm Date</th>   <th>Company</th><th>Product</th><th>Size</th> <th>Order Qty</th><th>Unit Price</th> <th>Quoted By</th> <th>Status</th> <th>Result</th>'; 
  $COLUMNS = ''; 
  $TABLE_HEADING = ''; 

    if (filter_has_var(INPUT_POST, 'SetColumns') )
    {

        if (in_array("200", $_POST)) $DEFAULT_COLUMNS .= ','; 

        foreach ($_POST as $key => $POST)
        {
            if ($POST === '200')
            {
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

            $Query="SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
            LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' GROUP BY ProductName ";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';

            $DataRows  = $Controller->QueryData($Query, []);

            $PaginateQuery="SELECT  COUNT(CTNId) AS RowCount FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
            LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status'";
             $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
             $row = $RowCount->fetch_assoc(); 
           
             $pagination->records($RowCount->num_rows);
             $pagination->records_per_page($RECORD_PER_PAGE);
    }  
    else
    {
        $DEFAULT_TABLE_HEADING .= '<th>OPS</th>' ;

        $Query = "SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
        LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' GROUP BY ProductName "; 
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows  = $Controller->QueryData($Query, []);

        
        $PaginateQuery="SELECT  COUNT(CTNId) AS RowCount FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
        LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' GROUP BY ProductName  ";
         $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        //  $row = $RowCount->fetch_assoc(); 
         $pagination->records($RowCount->num_rows);
         $pagination->records_per_page($RECORD_PER_PAGE);
    }

    if (filter_has_var(INPUT_POST, 'catagori') )
    {
        $CustomerName=$_POST['catagori'];
        if( $CustomerName == 'ALL') 
        {
            $Query="SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
            LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' GROUP BY ProductName ";
            $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, []);

             
            $PaginateQuery="SELECT  COUNT(CTNId) AS RowCount FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
            LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' ";
            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 

            $pagination->records($RowCount->num_rows);
            $pagination->records_per_page($RECORD_PER_PAGE);

        }
        else
        {
            $Query="SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
            LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' AND  ppcustomer.CustName = ? GROUP BY ProductName";
             $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
            $DataRows  = $Controller->QueryData($Query, [$CustomerName]);

            $PaginateQuery="SELECT  COUNT(CTNId) AS RowCount FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
            LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow WHERE JobNo = 'NULL' AND  CTNStatus='$Status' ";
            $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
            $row = $RowCount->fetch_assoc(); 
        
            $pagination->records($RowCount->num_rows);
            $pagination->records_per_page($RECORD_PER_PAGE);
        }
    }
    // Ending area of back-end logic 

 $FileAddress = pathinfo(__FILE__);   
?>

<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between ">
        <div class = "d-flex justify-content-start " >
        <a class= "btn btn-outline-primary  " href="IndividualFollowUpPage.php?Type=<?=$Type?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>     
        <h5 class = "m-0 ps-2 py-2 " > 
            <svg width="35" height="35" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5 0C9.63261 0 9.75979 0.0526784 9.85355 0.146447C9.94732 0.240215 10 0.367392 10 0.5C10 0.632608 10.0527 0.759785 10.1464 0.853553C10.2402 0.947322 10.3674 1 10.5 1C10.6326 1 10.7598 1.05268 10.8536 1.14645C10.9473 1.24021 11 1.36739 11 1.5V2C11 2.13261 10.9473 2.25979 10.8536 2.35355C10.7598 2.44732 10.6326 2.5 10.5 2.5H5.5C5.36739 2.5 5.24021 2.44732 5.14645 2.35355C5.05268 2.25979 5 2.13261 5 2V1.5C5 1.36739 5.05268 1.24021 5.14645 1.14645C5.24021 1.05268 5.36739 1 5.5 1C5.63261 1 5.75979 0.947322 5.85355 0.853553C5.94732 0.759785 6 0.632608 6 0.5C6 0.367392 6.05268 0.240215 6.14645 0.146447C6.24021 0.0526784 6.36739 0 6.5 0L9.5 0Z" fill="black"/>
                <path d="M3 2.5C3 2.36739 3.05268 2.24021 3.14645 2.14645C3.24021 2.05268 3.36739 2 3.5 2H4C4.13261 2 4.25979 1.94732 4.35355 1.85355C4.44732 1.75979 4.5 1.63261 4.5 1.5C4.5 1.36739 4.44732 1.24021 4.35355 1.14645C4.25979 1.05268 4.13261 1 4 1H3.5C3.10218 1 2.72064 1.15804 2.43934 1.43934C2.15804 1.72064 2 2.10218 2 2.5V14.5C2 14.8978 2.15804 15.2794 2.43934 15.5607C2.72064 15.842 3.10218 16 3.5 16H12.5C12.8978 16 13.2794 15.842 13.5607 15.5607C13.842 15.2794 14 14.8978 14 14.5V2.5C14 2.10218 13.842 1.72064 13.5607 1.43934C13.2794 1.15804 12.8978 1 12.5 1H12C11.8674 1 11.7402 1.05268 11.6464 1.14645C11.5527 1.24021 11.5 1.36739 11.5 1.5C11.5 1.63261 11.5527 1.75979 11.6464 1.85355C11.7402 1.94732 11.8674 2 12 2H12.5C12.6326 2 12.7598 2.05268 12.8536 2.14645C12.9473 2.24021 13 2.36739 13 2.5V14.5C13 14.6326 12.9473 14.7598 12.8536 14.8536C12.7598 14.9473 12.6326 15 12.5 15H3.5C3.36739 15 3.24021 14.9473 3.14645 14.8536C3.05268 14.7598 3 14.6326 3 14.5V2.5Z" fill="black"/>
                <path d="M7.5 11C7.5 11 7 11 7 10.5C7 10 7.5 8.5 9.5 8.5C11.5 8.5 12 10 12 10.5C12 11 11.5 11 11.5 11H7.5ZM9.5 8C9.89782 8 10.2794 7.84196 10.5607 7.56066C10.842 7.27936 11 6.89782 11 6.5C11 6.10218 10.842 5.72064 10.5607 5.43934C10.2794 5.15804 9.89782 5 9.5 5C9.10218 5 8.72064 5.15804 8.43934 5.43934C8.15804 5.72064 8 6.10218 8 6.5C8 6.89782 8.15804 7.27936 8.43934 7.56066C8.72064 7.84196 9.10218 8 9.5 8V8Z" fill="black"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.608 11.0002C6.53388 10.8441 6.49691 10.673 6.5 10.5002C6.5 9.82271 6.84 9.12521 7.468 8.64021C7.15455 8.54363 6.82797 8.4964 6.5 8.50021C4.5 8.50021 4 10.0002 4 10.5002C4 11.0002 4.5 11.0002 4.5 11.0002H6.608Z" fill="black"/>
                <path d="M6.25 8C6.58152 8 6.89946 7.8683 7.13388 7.63388C7.3683 7.39946 7.5 7.08152 7.5 6.75C7.5 6.41848 7.3683 6.10054 7.13388 5.86612C6.89946 5.6317 6.58152 5.5 6.25 5.5C5.91848 5.5 5.60054 5.6317 5.36612 5.86612C5.1317 6.10054 5 6.41848 5 6.75C5 7.08152 5.1317 7.39946 5.36612 7.63388C5.60054 7.8683 5.91848 8 6.25 8V8Z" fill="black"/>
            </svg>

                <?=$ListTitle ?> Quotation List<span style= "color:#FA8b09;" > <?php if(isset($_POST['catagori'])) echo " - (".$_POST['catagori']." ) "; ?> </span>
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
<div class="card mb-3  ms-3 me-3" style = "font-family: Roboto,sans-serif;"> <!-- start of the card div -->
   <div class="card-body "><!-- start of the card-body div -->
        <form action="" method="POST">
        <input type="hidden" name="Type" value = "<?=$Type ?>">
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">		

                    <select class="form-select  " name="catagori"  onchange="this.form.submit()">
				        <option>Select Catagory</option>
				        <option value = "ALL"> All </option><!--Basically the below php script is used to fetch the data of the customer (Customer Name) from to table in between catagory-->
                        <?php  
                                $CustomerNames  = $Controller->QueryData("SELECT DISTINCT carton.CustId1 ,ppcustomer.CustName 
                                FROM carton INNER JOIN  ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE JobNo = 'NULL' AND CTNStatus='$Status'", []);
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
                <?php $counter = 1;  
                    foreach ($DataRows as $RowsKey => $Rows)
                    {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>"; 
                        foreach ($Rows as $key => $value) :?>
                            <?php if($key == 'CtnCurrency'  ) continue; ?>
                            <td Class = "<?php if($key == 'CTNPrice') echo 'text-end';  ?> " > 
                                <?=$value ?> 
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
                        
                        <a class="text-primary m-1" href="FollowUpForm.php?id=<?= $Rows['CTNId'] ?>&Address=<?= $FileAddress['filename']?>" title="Follow Up" >  
                          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                          <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                          <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                          <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                          </svg>
                        </a>
                    </td>
                <?php
                         echo "</tr>";
                    }  # end of   loop  ?>
            </tbody>
        </table>
    </div><!-- End of table div -->
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
        <h5 class="modal-title" id="staticBackdropLabel"><?=$ListTitle?> Quotation List Columns</h5>
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
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusProvince"> Province</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "JobType"> Ply-Type</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNColor"> Color</label> </div>
                    </div><!-- END OF COL  -->
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "FinalTotal" > Total-Amount</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "CtnCurrency" > Currency</label> </div>
                                
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "FollowComment" > comment</label> </div>
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


