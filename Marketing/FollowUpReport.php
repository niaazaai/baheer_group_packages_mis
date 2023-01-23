<!-- 
    * This is Follow Up Report which is linked directly with the Marketing menu drop down list by the name of Cancel List the file name is (CancelQuotation.php).
    * In here only the data of those customer will be listed which are only have  Cancelled status .
    * We have put setup functionality in this page which is made by ( Masiuallah Naizi ) Developer in Baheer group.
    Note: Please check the setup Functionality of this page and test it, it has some problem with size Column of the table which is the combination of three fields from table
          name carton and fields name are ( CTNLenght ) X (CTNWidth) X (CTNHeight), which has some problem in displaying.
    * note that also corss check the Query also whether it is right or not... And also It's live search is not working when we add some fields form setup.
    * The live search functionality is still reamining need to be added.

    *(Page Developed By-----------------------------------------------------------+> Furqan Ahmad Hajizada <+------------------------------------------------------------------)*
 -->

 <!-- Starting area of back-end logic-->
<?php   require_once '../App/partials/Header.inc';  ?>
<?php   require_once '../App/partials/Menu/MarketingMenu.inc';
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
        //  die('<div class="alert alert-danger d-flex align-items-center m-3" role="alert">
        //      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
        //          <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z"/>
        //          <path d="M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
        //      </svg>
        //      <div class = "ms-1  " > <strong>  Incorrect Type </strong>: This Incident Will be reported!   <a class= "  link " href="FUP.php">  Back  </a>     </div>
        //  </div>'); 
    }
  
  } 
  else {
     
    //  die('<div class="alert alert-danger d-flex align-items-center m-3" role="alert">
    //      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
    //          <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z"/>
    //          <path d="M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
    //      </svg>
    //      <div class = "ms-1  " > <strong>  No Type Provided </strong>: This Incident Will be reported!   <a class= "  link " href="FUP.php">  Back  </a>     </div>
    //  </div>'); 
  
  }




        $DEFAULT_COLUMNS = ' CusStatus ,FollowDate, carton.JobNo, ppcustomer.CustName,ProductName,CONCAT(CTNLength," x ",CTNWidth, " x " ,CTNHeight) as size, ctnfollowup.FollowResult,employeet.Ename'; 
        $DEFAULT_TABLE_HEADING = '<th>#</th><th>Date</th><th>Task Type</th><th>Company</th><th>Product</th><th>Size</th> <th>Result</th><th>Lead By</th>'; 
        $COLUMNS = ''; 
        $TABLE_HEADING = ''; 
        $RECORD_PER_PAGE = 50;

    if (filter_has_var(INPUT_POST, 'SetColumns') ) {

        $EmployeeName= $Controller->CleanInput($_POST['EmployeeName']);
        $FollowResult= $Controller->CleanInput($_POST['FollowResult']);
        $From= $Controller->CleanInput($_POST['From']);
        $To=$Controller->CleanInput($_POST['To']);

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

        if($EmployeeName == 'ALL' && $FollowResult == 'ALL'){

            if(!empty($From) && !empty($To)){
                $Query  = "SELECT  $DEFAULT_COLUMNS
                FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
                INNER JOIN employeet ON employeet.EId=carton.EmpId 
                LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow 
                WHERE FollowDate between ? AND ? AND CTNStatus='$Status' ORDER BY FollowDate DESC "; 
                $DataRows  = $Controller->QueryData($Query, [$From,$To]);

            }
            else {
                $Query  = "SELECT  $DEFAULT_COLUMNS
                FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
                INNER JOIN employeet ON employeet.EId=carton.EmpId 
                LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow 
                WHERE CTNStatus='$Status' ORDER BY FollowDate DESC LIMIT 25"; 
                $DataRows  = $Controller->QueryData($Query, []);
            }
             
        }
        elseif($EmployeeName == 'ALL' && $FollowResult != 'ALL'){
            $Query="SELECT  $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow 
            where FollowResult=? AND FollowDate between ? AND ? AND CTNStatus='$Status' ORDER BY FollowDate DESC  ";
            

            $DataRows  = $Controller->QueryData($Query, [ $FollowResult,$From,$To]);
            echo "ALL-Follow-Result";

        }
        elseif($EmployeeName != 'ALL' && $FollowResult == 'ALL'){
            $Query="SELECT  $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow 
            where Ename=?   AND FollowDate between ? AND ? AND CTNStatus='$Status' ORDER BY FollowDate DESC ";
            $DataRows  = $Controller->QueryData($Query, [$EmployeeName,$From,$To]);
        }
        elseif($EmployeeName != 'ALL' && $FollowResult != 'ALL'){
            $Query="SELECT  $DEFAULT_COLUMNS
            FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
            INNER JOIN employeet ON employeet.EId=carton.EmpId 
            LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow 
            WHERE Ename=? AND FollowResult=? AND FollowDate between ? AND ? AND CTNStatus='$Status' ORDER BY FollowDate DESC ";
            $DataRows  = $Controller->QueryData($Query, [$EmployeeName,$FollowResult,$From,$To]);
        }
 
    }  # END OF IF 
    else
    {        
         
        $Query="SELECT  $DEFAULT_COLUMNS
        FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN employeet ON employeet.EId=carton.EmpId LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow where  CTNStatus='$Status' ORDER BY FollowDate DESC  ";
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';

        $DataRows  = $Controller->QueryData($Query, []);



        $PaginateQuery = "SELECT  COUNT(Ename) AS RowCount  
        FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN employeet ON employeet.EId=carton.EmpId LEFT OUTER JOIN ctnfollowup ON carton.EmpId=ctnfollowup.EmpIdFollow where  CTNStatus='$Status' ORDER BY FollowDate DESC LIMIT 15 "; 
        $RowCount =  $Controller->QueryData(   $PaginateQuery , []  );
        $row = $RowCount->fetch_assoc(); 
        $pagination->records($row['RowCount']);
        $pagination->records_per_page($RECORD_PER_PAGE);



       
     } # END OF ELSE

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
        <svg width="30" height="30" viewBox="0 0 220 246" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_20_12)">
                        <line y1="121" x2="233" y2="121" stroke="black" stroke-width="15"></line>
                        <path d="M77 65V65C77 56.7157 83.7157 50 92 50H138C146.284 50 153 56.7157 153 65V65" stroke="black" stroke-width="15"></path>
                        <path d="M78 177V177C78 168.716 84.7157 162 93 162H139C147.284 162 154 168.716 154 177V177" stroke="black" stroke-width="15"></path>
                        </g>
                        <rect x="4" y="4" width="212" height="238" rx="21" stroke="black" stroke-width="15"></rect>
                        <defs>
                        <clipPath id="clip0_20_12">
                        <rect width="220" height="246" rx="25" fill="black"></rect>
                        </clipPath>
                        </defs>
                    </svg>
                Follow Up Report <span style= "color:#FA8b09;" > <?php if(isset($_POST['EmployeeName']))  echo " - ( " . $_POST['EmployeeName'] . " )"?> </span>
                <span class = "badge bg-success"> <?=$ListTitle ?></span>
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




<div class="card m-3 ">
    <div class="card-body  ">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <input type="hidden" name = "Type" value = "<?=$Type?>">

    <div class="row">


        <div class = "col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <label class="form-label">Follower Name</label>
                <select class="form-select " name="EmployeeName">
                <option disabled >Lead By</option>       
                <option value="ALL">ALL</option>
                    <?php  
                        $EmployeeNames = $Controller->QueryData("SELECT DISTINCT carton.EmpId ,employeet.Eid,employeet.Ename FROM carton INNER JOIN employeet ON employeet.Eid=carton.EmpId WHERE CTNStatus='Pending'", []);
                        foreach (  $EmployeeNames as $RowsKey => $Rows)  {
                    ?>
                            <option value="<?php echo $Rows['Ename']; ?>">
                                <?php echo $Rows['Ename']; ?>
                            </option>
                    <?php
                        }
                    ?>
                </select>
        </div><!-- END OF COL   -->
        <div class = "col-lg-2 col-md-3 col-sm-6 col-xs-12">

                <label class="form-label">Result</label>
                <select class="form-select  " name="FollowResult"  >
                <option value="ALL">ALL</option>
                <option disabled >Follow Result</option>        
                <?php  
                    $FollowResults = $Controller->QueryData("SELECT DISTINCT carton.EmpId ,employeet.Eid,ctnfollowup.FollowResult 
                    FROM carton 
                    INNER JOIN employeet ON employeet.Eid=carton.EmpId 
                    INNER JOIN ctnfollowup ON employeet.Eid=ctnfollowup.EmpIdFollow 
                    WHERE CTNStatus='Pending'", []);
                    foreach ($FollowResults as $RowsKey => $Rows) 
                    {
                ?>
                        <option value="<?php echo $Rows['FollowResult']; ?>">
                            <?php echo $Rows['FollowResult']; ?>
                        </option>
                <?php
                    }
                ?>
                </select>
        </div><!-- END OF COL   -->
        <div class = "col-lg-2 col-md-3 col-sm-6 col-xs-12">
            <label class="form-label">From</label>
            <input type="date" class="form-control" name="From">
        </div>
        <div class = "col-lg-2 col-md-3 col-sm-6 col-xs-12">
            <label class="form-label">To</label>
            <input type="date" class="form-control" name="To" onchange = "this.form.submit();"  >
        </div> 

    </form>

        <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12  mt-4  ">

            <div class="search mb-3">
                <i class="fa-search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </i>
                <input type="text" class="form-control" id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'myTable' )">
            </div>
        </div>



    </div>
          

      

    


    </div>
</div> 





<!-- Start body of table Card -->
<div class="card   m-3"> <!-- Start tag of card div -->
    <div class="card-body table-responsive "><!-- start of table div -->
       
    <div class="h3 text-center ">
            <span><?php if(isset($_POST['EmployeeName'])) echo $_POST['EmployeeName']; ?> </span>
            Follow Up Report  
            <?php  if( ( isset($_POST['From']) && !empty($_POST['From']) ) && (isset($_POST['To']) && !empty($_POST['To']) )  ) echo 'From ( '.  $_POST['From'] . ' ) To ( ' .  $_POST['To'] . ' )'; ?>



        </div>
<hr>

        <table class="table mt-5" id="myTable">
            <thead>
                <tr>
			        <?php if(isset($DEFAULT_TABLE_HEADING)) echo $DEFAULT_TABLE_HEADING ;  ?>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1 ;
                    foreach ($DataRows as $RowsKey => $Rows)
                    {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>"; 
                        foreach ($Rows as $key => $value) :?>
                             <?php if($key == 'CusStatus') continue; ?>
                            <td>  
                                <?php if($key == 'JobNo') {
                                        $Text = ($Status == 'InActive') ? 'IA' : 'PND'; 
                                        if($value == 'NULL'  ){
                                            echo '<span class = "badge bg-danger" >'.$Text.'-Quotation</span>'; 
                                        }
                                        elseif($value != 'NULL'   ) {
                                            echo '<span class = "badge bg-primary" >'.$Text.'-Products </span>'; 
                                        }
                                        elseif(isset($Rows['CusStatus']) == $Status ){
                                            echo '<span class = "badge bg-info" >PND-Customer</span>';
                                        }
                                        $value = NULL;
                                } ?>   
                                <?=$value?> 
                            </td>
                        <?php endforeach;   ?> 
                <?php  echo "</tr>";
                    }  # end of   loop  ?>
            </tbody>
        </table>
    </div><!-- End of table div -->
</div> <!-- End tag of card div -->
<!-- Start body of table Card -->
 




<div class="card m-3 ">
    <div class="card-body d-flex justify-content-center">
    <?=$pagination->render();?>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"><!-- Start of the model div -->
  <div class="modal-dialog modal-xl"> <!-- Start of the model-dialog div -->
    <div class="modal-content">  <!-- Start of the model-content div -->
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?=$ListTitle;  ?> Quotation List Columns</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
    <input type="hidden" name = "Type" value = "<?=$Type?>">

        <input type="hidden" name="infoSetColumns" value = "Okay">
            <div class="modal-body">
            <div class="row">
                <div class = "col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label class="form-label">Follower Name</label>
                        <select class="form-select " name="EmployeeName">
                        <option value="ALL">ALL</option>
                        <option disabled >Lead By</option>        
                        <?php  
                            $EmployeeNames = $Controller->QueryData("SELECT DISTINCT carton.EmpId ,employeet.Eid,employeet.Ename FROM carton INNER JOIN employeet ON employeet.Eid=carton.EmpId WHERE CTNStatus='$Status'", []);
                            foreach (  $EmployeeNames as $RowsKey => $Rows) 
                            {
                        ?>
							    <option value="<?php echo $Rows['Ename']; ?>">
								    <?php echo $Rows['Ename']; ?>
							    </option>
				        <?php
                            }
                        ?>
                        </select>
                </div><!-- END OF COL   -->
                <div class = "col-lg-3 col-md-3 col-sm-6 col-xs-12">

                        <label class="form-label">Result</label>
                        <select class="form-select  " name="FollowResult"  >
                        <option value="ALL">ALL</option>
                        <option disabled >Follow Result</option>        
                        <?php  
                            $FollowResults = $Controller->QueryData("SELECT DISTINCT carton.EmpId ,employeet.Eid,ctnfollowup.FollowResult 
                            FROM carton INNER JOIN employeet ON employeet.Eid=carton.EmpId INNER JOIN ctnfollowup ON employeet.Eid=ctnfollowup.EmpIdFollow WHERE CTNStatus='$Status'", []);
                            foreach ($FollowResults as $RowsKey => $Rows) 
                            {
                        ?>
							    <option value="<?php echo $Rows['FollowResult']; ?>">
								    <?php echo $Rows['FollowResult']; ?>
							    </option>
				        <?php
                            }
                        ?>
                        </select>
                </div><!-- END OF COL   -->
                <div class = "col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <label class="form-label">From</label>
                    <input type="date" class="form-control" name="From">
                </div>
                <div class = "col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <label class="form-label">To</label>
                    <input type="date" class="form-control" name="To">
                </div>
            </div>
                 <hr>
                <div class="row">             
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <input type="hidden" name="SetColumns" value = "Okay">
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "PexchangeUSD" > Exchange-Rate</label> </div>
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "GrdPrice"> Paper-Grade</label> </div>
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "CompitatorName"> Competitor-Name</label> </div>
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNPrice"> Unit Price</label> </div>
                    </div><!-- END OF COL  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "OtherPrice"> Competitor-Price</label> </div>
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "FollowVia"> Contact-Via</label> </div>
                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "FollowComment"> Comment</label> </div> 
                    </div><!-- END OF COL   -->
                </div><!-- END OF ROW  -->
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



