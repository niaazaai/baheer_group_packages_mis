
<?php require_once '../App/partials/Header.inc';   ?>

<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
<?php 

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





require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 15;

$DEFAULT_COLUMNS = 'CustId,ctnfollowup.AlarmDate,ppcustomer.CustName,ProductName,employeet.Ename,CusStatus,ctnfollowup.FollowResult'; 
$DEFAULT_TABLE_HEADING = "  <th>#</th><th>Alarm Date</th><th>Company</th><th>Product Name</th><th>Quoted By</th><th> Status</th><th>Result</th>";
$Query = ''; 

 if(isset($_POST) && !empty($_POST)) {
    
    if (filter_has_var(INPUT_POST, 'TaskList'))  {
      $TaskList = $_POST['TaskList'];
      $PageAddress = ""; 

     if($TaskList == 'Customer') 
     {
          $DEFAULT_COLUMNS = 'CustId,  MAX(ctnfollowup.AlarmDate) AS AlarmDate ,ppcustomer.CustName, employeet.Ename,ppcustomer.CusStatus,ctnfollowup.FollowResult'; 
          $DEFAULT_TABLE_HEADING = "  <th>#</th><th>Alarm Date</th><th>Company</th> <th>Quoted By</th><th> Status</th><th>FU Result</th>";
          $Query = "SELECT $DEFAULT_COLUMNS FROM ppcustomer   
          LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow 
          LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow  
          WHERE CusStatus = '$Status' AND  DATE(ctnfollowup.AlarmDate) <= DATE(NOW()) GROUP BY CustName";
          //  REMEMBER : if the you all ctnfollowup.AlarmDates must be checked to show data correctly. or you can change condtion to OR 
          $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';

          $PaginateQuery= "SELECT COUNT(CustId) AS RowCount FROM ppcustomer   
          LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow 
          LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow  
          WHERE CusStatus = '$Status' AND  DATE(ctnfollowup.AlarmDate) <= DATE(NOW()) GROUP BY CustName";

          $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
          $row = $RowCount->fetch_assoc(); 
          if(!isset($row['RowCount']) && empty($row['RowCount'])){
            $row['RowCount'] = 0 ; 
          }

          $pagination->records($RowCount->num_rows);
          $pagination->records_per_page($RECORD_PER_PAGE);

          $PageAddress = 'CustomerFollowUpForm.php'; 
     }

     elseif($TaskList == 'Product') 
     {
          $Query="SELECT $DEFAULT_COLUMNS FROM carton 
          LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
          LEFT JOIN employeet ON employeet.EId=carton.EmpId 
          LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
          WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";
          $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';

          $PaginateQuery="SELECT COUNT(CTNId) AS RowCount  FROM carton 
          LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
          LEFT JOIN employeet ON employeet.EId=carton.EmpId 
          LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
          WHERE JobNo!='NULL' AND CTNStatus='$Status' order by CTNId ASC";

          $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
          $row = $RowCount->fetch_assoc(); 
          if(!isset($row['RowCount']) && empty($row['RowCount'])){
            $row['RowCount'] = 0 ; 
          }


          $pagination->records($RowCount->num_rows);
          $pagination->records_per_page($RECORD_PER_PAGE);

          $PageAddress = 'FollowUpForm.php';
     }

     elseif($TaskList == 'Quotation') 
     {

          $DEFAULT_COLUMNS = ' CustId , CTNId ,  MAX(ctnfollowup.AlarmDate) AS AlarmDate ,ppcustomer.CustName,carton.ProductName,employeet.Ename,CTNStatus,ctnfollowup.FollowResult'; 
          $DEFAULT_TABLE_HEADING = "  <th>#</th> <th>Alarm Date</th><th>Company</th><th>Product Name</th><th>Quoted By</th><th> Status</th><th>FU Result</th>";
          $Query = "SELECT $DEFAULT_COLUMNS  
          FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
          LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
          LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow 
          WHERE JobNo = 'NULL' AND  CTNStatus='$Status' AND (DATE( AlarmDate)  <=  DATE(NOW() ))   GROUP BY ProductName"; 
          $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';

      
          $PaginateQuery = "SELECT  COUNT(CTNId) AS RowCount 
          FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
          LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
          LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow 
          WHERE JobNo = 'NULL' AND  CTNStatus='$Status' AND (DATE( AlarmDate)  <=  DATE(NOW() ))   GROUP BY ProductName"; 
          
          $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
          $row = $RowCount->fetch_assoc(); 
          if(!isset($row['RowCount']) && empty($row['RowCount'])){
            $row['RowCount'] = 0 ; 
          }

          $pagination->records($RowCount->num_rows);
          $pagination->records_per_page($RECORD_PER_PAGE);
          $PageAddress = 'FollowUpForm.php';
     }
     else 
     { 
        $Query = "SELECT $DEFAULT_COLUMNS  FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT JOIN employeet ON employeet.EId=carton.EmpId 
        LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
        WHERE CusStatus= '$Status'  OR  DATE(ctnfollowup.AlarmDate)  <=  DATE(NOW())  GROUP BY CustName";
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';

        $PaginateQuery = "SELECT COUNT(CustId) AS RowCount  FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT JOIN employeet ON employeet.EId=carton.EmpId 
        LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
        WHERE CusStatus= '$Status'  OR  DATE(ctnfollowup.AlarmDate)  <=  DATE(NOW())  GROUP BY CustName";

        $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 
        
        $pagination->records($RowCount->num_rows);
        $pagination->records_per_page($RECORD_PER_PAGE);

     }

     $DEFAULT_TABLE_HEADING .= "<th>OPS</th>";
     $DataRows  = $Controller->QueryData($Query, []);
  }
 }
 else {
    $Query="SELECT $DEFAULT_COLUMNS  FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    LEFT JOIN employeet ON employeet.EId=carton.EmpId 
    LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
    WHERE CusStatus= '$Status'  OR  DATE(ctnfollowup.AlarmDate)  <=  DATE(NOW())  GROUP BY CustName ";
    $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE .' ';
    $PageAddress = 'CustomerFollowUpForm.php'; 
    $DataRows  = $Controller->QueryData($Query, []);

    $PaginateQuery = "SELECT COUNT(CustId) AS RowCount  FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
    LEFT JOIN employeet ON employeet.EId=carton.EmpId 
    LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
    WHERE CusStatus= '$Status'  OR  DATE(ctnfollowup.AlarmDate)  <=  DATE(NOW())  GROUP BY CustName";

    $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
    $row = $RowCount->fetch_assoc(); 
    $pagination->records($RowCount->num_rows);
    $pagination->records_per_page($RECORD_PER_PAGE);

    $DEFAULT_TABLE_HEADING .= "<th>OPS</th>";
 }

  $FileAddress = pathinfo(__FILE__);  
?>


<div class="card mb-3 mt-3 ms-3 me-3 ">
    <div class="card-body d-flex justify-content-between ">
      <div class=" d-flex justify-content-start ">
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
                  Task List <span style= "color:#FA8b09;" > <?php if(isset($_POST['TaskList']))  echo " - ( $ListTitle " . $_POST['TaskList'] . " )"; else echo ' - ALL' ;?> </span>
            </h5>
      </div>    
      <div>
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

<div class="card m-3" style = "font-family: Roboto,sans-serif;">
   <div class="card-body ">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
          <input type="hidden" name="Type" value = "<?=$Type ?>">
          
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">		
                    <select class="form-select  " name="TaskList"  onchange="this.form.submit()">
				                <option>Select Task Type</option>
                        <option value="Customer"><?php if($Type == 'General'){echo $ListTitle;}elseif($Type == 'Individual'){echo $ListTitle;} ?> Customer</option>
				                <option value="Product"><?php if($Type == 'General'){echo $ListTitle;}elseif($Type == 'Individual'){echo $ListTitle;}?> Product</option><!--Basically the below php script is used to fetch the data of the customer (Customer Name) from to table in between catagory-->
                        <option value="Quotation"><?php if($Type == 'General'){echo $ListTitle;}elseif($Type == 'Individual'){echo $ListTitle;}?> Quotation</option>
			        </select>
		        </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                    <input type="text" class= "form-control mb-2" id = "Search_input" placeholder = "Search Here"  onkeyup="search( this.id , 'TaskListTable' )" >  
                </div>
	        </div><!-- End Tag of div row -->
        </form>
    </div>
</div>

<div class="card  m-3"> <!-- Start tag of card div -->
    <div class=" card-body table-responsive  ">
    <table class="table "  id = "TaskListTable"  >
          <thead>
            <tr>   <?php if (isset($DEFAULT_TABLE_HEADING))  echo  $DEFAULT_TABLE_HEADING ?>   </tr>
          </thead>
          <tbody>
            <?php 
            if (is_array($DataRows) || is_object($DataRows)) {
                $counter  = 1 ;  
              foreach ($DataRows as $RowsKey => $Rows) {

                  echo "<tr style = 'padding-bottom:0px;'  >";
                  echo "<td>" . $counter++ . "</td>"; 

                    foreach ($Rows as $key => $value) :?>
                      <?php if( ($key == 'CustId') || ($key == 'CTNId') ) continue;  ?>
                      <td >  <?php if($key=='AlarmDate'){echo date('Y-m-d h:i:s A' , strtotime($value));}else{ print $value; } ?>   </td>
                    <?php endforeach; ?> 
                    <td> 
                        <a class="text-primary m-1" href="CustomerEditForm.php?id=<?= $Rows['CustId'] ?> " title="Edit">  
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <a class="text-primary m-1" href="<?=(isset($PageAddress) ? $PageAddress: 'PendingTaskList.php'  )?>?id=<?=$Rows['CustId']?> &CTNId=<?php if(isset($Rows['CTNId']))echo $Rows['CTNId'];?>&Address=<?=$FileAddress['filename']?>&Type=<?=$Type?>" title="Follow Up" >  
                          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                          <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                          <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                          <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                          </svg>
                        </a>
                    </td>
                <?php echo "</tr>";
                }
            }// end of while loop
            else { ?>
            <tr class = "fs-5 text-danger text-center " colspan = "5"  >
              <td>NO RECORD FOUND </td>
            </tr>
            <?php    }// ELSE BLOCK IF CONDITION ?>
          </tbody>
        </table>
  </div>
</div>

<div class="card ms-3 me-3">
    <div class="card-body d-flex justify-content-center">
        <?php  $pagination->render(); ?>
    </div>
</div>

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