<!-- 
    * This is Task List page named (TaskList.php), which is linked with the follow up page named (IndividualFollowUpPage.php) dashboard.
    * This is page basically functions, when ever we select from drop down list acoording to select type. 

    * if it's Pending Cutomer it should bring the data of those customer 
      which has status of pending in database but for now it's status is InActive, and according the decision of higher autority it's status should change form InActive to 
      pending.

    * if it's Pending Pending Product it should bring the data of those Product which has status of pending in database but for now it's status is InActive, 
      and according the decision of higher autority it's status should change form InActive to pending.

    * if it's Pending Quotation it should bring the data of those Quotation which has status of pending in database but for now it's status is InActive, and acoording the 
      decision of higher autority it's status should change form InActive to pending.  
    
    * Dear Developer please check the query also at the time of compiletion

    *(Page Developed By-----------------------------------------------------------+> Furqan Ahmad Hajizada <+------------------------------------------------------------------)    
    
 -->
<?php 
require_once '../App/partials/Header.inc';  
require_once '../App/partials/Menu/MarketingMenu.inc'; 

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
$RECORD_PER_PAGE = 5;
?>  
<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between ">
            <div class="d-flex justify-content-start ">
                <a class= "btn btn-outline-primary  " href="IndividualFollowUpPage.php?Type=<?=$Type?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </a>     
                <h5 class = "m-0 ps-2 py-2 " > 
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                </svg>
                        <?=$ListTitle ?> Customer List <span style= "color:#FA8b09;" > <?php if(isset($_POST['catagori'])) echo " - (".$_POST['catagori']." ) "; ?> </span>
                    </h5>
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

<div class="card m-3" style = "font-family: Roboto,sans-serif;">
   <div class="card-body ">
        <form action="" method="POST">
            <input type="hidden" name = "Type" value = "<?=$Type?>">
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">		
                <select class="form-control " name="catagory"  onchange="this.form.submit()">
				<option>Select Catagory</option>
				<option value = "All"> All </option><!--Basically the below php script is used to fetch the data of the customer (Customer Name) from to table in between catagory-->
				<?php
                        $Query = "SELECT  ppcustomer.CustName  
                        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
                        WHERE CusStatus= '$Status' GROUP BY CustName";

                        $DataRows  = $Controller->QueryData($Query, []);
						if (is_array($DataRows) || is_object($DataRows))
						{
							foreach ($DataRows as $RowsKey => $Rows)  { 	?>
							<option value="<?php echo $Rows['CustName']; ?>"> <?php echo $Rows['CustName']; ?> 	</option>
				        <?php }
						}
				?>
			</select>
		        </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                    <input class="form-control " type="search" name="Search" id="Search" placeholder="Search anything  " onkeyup="SearchFunction(this.id,'myTable')">
                </div>
	        </div><!-- End Tag of div row -->
        </form>
    </div>
</div>

<?php

$DEFAULT_COLUMNS = "ppcustomer.CustId , ppcustomer.CustName, ppcustomer.CusStatus,ppcustomer.CustWorkPhone,ppcustomer.CusSpecification,ppcustomer.AgencyName, ctnfollowup.AlarmDate,ctnfollowup.FollowResult";
if(isset($_POST['catagory']) && !empty($_POST['catagory']) )
{   
    $catagory=$_POST['catagory'];
    if($catagory == 'All')  
    {     
        $Query = "SELECT  $DEFAULT_COLUMNS
        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
        WHERE CusStatus= '$Status' GROUP BY CustName"; 
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows  = $Controller->QueryData($Query, [] );

        $PaginateQuery = "SELECT COUNT(CustId) AS RowCount
        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
        WHERE CusStatus= '$Status' GROUP BY CustName"; 
        $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 
    
        $pagination->records($RowCount->num_rows);
        $pagination->records_per_page($RECORD_PER_PAGE);
    }
    else  
    {
        $Query = "SELECT  $DEFAULT_COLUMNS
        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
        WHERE  CustName = ? AND CusStatus= '$Status' GROUP BY CustName"; 
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows  = $Controller->QueryData($Query, [$catagory] );

        $PaginateQuery = "SELECT COUNT(CustId) AS RowCount
        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
        WHERE CusStatus= '$Status' GROUP BY CustName"; 
        $RowCount =  $Controller->QueryData($PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 
    
        $pagination->records($RowCount->num_rows);
        $pagination->records_per_page($RECORD_PER_PAGE);

    }
}
else{
        $Query = "SELECT  $DEFAULT_COLUMNS
        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
        WHERE  CusStatus= '$Status' GROUP BY CustName"; 
        $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
        $DataRows  = $Controller->QueryData($Query, [] );

        $PaginateQuery = "SELECT COUNT(CustId) AS RowCount
        FROM ppcustomer LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow  
        WHERE CusStatus= '$Status' GROUP BY CustName"; 
        $RowCount =  $Controller->QueryData($PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 
    
        $pagination->records($RowCount->num_rows);
        $pagination->records_per_page($RECORD_PER_PAGE);
}
?>

<div class="card  m-3"> <!-- Start tag of card div -->
    <div class="card-body table-responsive   ">
        <table class="table  " id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Alarm-Date</th>
                    <th scope="col">Company</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Specification</th>
                    <th scope="col">Agency</th>
                    <th scope="col">Status</th>
                    <th scope="col">Result</th>
                    <th scope="col">OPS</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (is_array($DataRows) || is_object($DataRows))
                {
                    $counter = 1; 
                    foreach ($DataRows as $RowsKey => $Rows) 
                    {
                            echo "<tr>";
                            echo "<td>".$counter++ ."</td>";   
                            echo "<td>".$Rows['AlarmDate'] ."</td>";                   
                            echo "<td>".$Rows['CustName']."</td>";
                            echo "<td>".$Rows['CustWorkPhone']."</td>";
                            echo "<td>".$Rows['CusSpecification']."</td>";
                            echo "<td>".$Rows['AgencyName']."</td>";
                            echo "<td>".$Rows['CusStatus']."</td>";
                            echo "<td>".$Rows['FollowResult']."</td>";
            ?>
                        <td> 
                            <a class="text-primary m-1" href="CustomerEditForm.php?id=<?= $Rows['CustId'];  ?> " title="Edit">  
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
                            <?php $FileAddress = pathinfo(__FILE__); ?>
                            <a class="text-primary m-1" href="CustomerFollowUpForm.php?id=<?=$Rows['CustId']?>&Address=<?php echo $FileAddress['filename'] ?>" title="Follow Up" >  
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                            </a>
                        </td>
                        <?php            
                            echo "</tr>";
                    }
                }
?>
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
    function SearchFunction(InputId ,tableId ) 
    {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(InputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++)
        {
            td = tr[i];
            if (td)
            {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) 
                {
                    tr[i].style.display = "";
                }
                else 
                {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<?php  require_once '../App/partials/Footer.inc'; ?>