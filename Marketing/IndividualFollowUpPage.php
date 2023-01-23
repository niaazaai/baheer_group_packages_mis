
<?php require_once '../App/partials/Header.inc';  ?>

<?php 

# THIS BLOCK WILL GET THE LIST TYPE WHICH GENERAL OR INDIVIDUAL 
if (filter_has_var(INPUT_GET, 'Type') ) {
   $Type = $Controller->CleanInput($_GET['Type']); 

   if($Type == 'General') {
    $Type = 'General';
   }
   elseif($Type == 'Individual') { 
    $Type = 'Individual';
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
else {
    
    die('<div class="alert alert-danger d-flex align-items-center m-3" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
            <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z"/>
            <path d="M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
        </svg>
        <div class = "ms-1  " > <strong>  No Type Provided </strong>: This Incident Will be reported!   <a class= "  link " href="FUP.php">  Back  </a>     </div>
    </div>'); 

}
 require_once '../App/partials/Menu/MarketingMenu.inc'; 
 ?>  
 
<style>
        .top-left         { padding-right:280px;}
        .bottom-center    { padding-top:40px;text-align:center; margin-top:50px;}
        .task-bg          { background-color:#78DEC7;}
        .pendingQ-bg      { background-color:#FF884B;}
        .pendingPro-bg    { background-color:#FF5D6C;}
        .pendingCus-bg    { background-color:#C299FC;}
        .report-bg        { background-color:#3EDBF0;}
        .circle-task      { background:#27AA80;}
        .circle-Quotation { background:#FF5200;}
        .circle-Product   { background:#FA163F;}
        .circle-Customer  { background:#8843F2;}
        .circle-Report    { background:#00ADB5;}
        .circle {
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            font-size: 28px;
            color: #fff;
            text-align: center;
            margin:0px; 
        }
    </style>




 <?php 
        $DEFAULT_COLUMNS = 'ctnfollowup.AlarmDate,carton.CTNId ,ppcustomer.CustName,ProductName,carton.CTNQTY,carton.CTNPrice,CONCAT(CTNLength,"X",CTNWidth,"X",CTNHeight) AS Size, carton.CTNStatus,ctnfollowup.FollowResult'; 
        // this block of code generate how many quotations we have currently. 
        
        
        $Query="SELECT COUNT( CTNId) AS QUOTATION FROM carton WHERE  JobNo = 'NULL' AND  CTNStatus='Pending'";
        $DataRows  = $Controller->QueryData($Query, []);    
        $Quotation = $DataRows->fetch_assoc(); 

        // this block of code generate how many quotations we have currently. 
        $Query="SELECT COUNT( CTNId) AS PRODUCT FROM carton    WHERE  JobNo != 'NULL' AND  CTNStatus='Pending'";
        $DataRows  = $Controller->QueryData($Query , []);    
        $Product = $DataRows->fetch_assoc(); 
        // echo $DataRows->num_rows; 

        // this block of code generate how many quotations we have currently. 
        $Query="SELECT COUNT(CustId) AS CUSTOMER FROM ppcustomer WHERE CusStatus= 'Pending'";
        $DataRows  = $Controller->QueryData($Query , []);    
        $Customer = $DataRows->fetch_assoc(); 
        $TaskList =  $Quotation['QUOTATION']  +  $Product['PRODUCT'] + $Customer['CUSTOMER'];


 ?>  
<div class="card m-3   ">
    <div class="card-body d-flex justify-content-between">
        <div class="card-body d-flex justify-content-start">
            <a class= "btn btn-outline-primary  " href="FUP.php ">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>     
            
        <h4 class="ms-2 my-1"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
            </svg>
           
            <?=$Type ?> Follow Up Page
        </h4>
        </div>
        <!-- <div> -->
            <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
			    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
				    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
				    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
				    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
			    </svg>
			</a>
        <!-- </div> -->
    </div>  
</div>

<div class="card  m-3">
    <div class="card-body">
        

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="card task-bg shadow">
            <div class="card-body pb-3 pt-3"  >
                <div class= "d-flex justify-content-between">
                    <div class = "fs-2 text-white" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
                            <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
                            <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
                        </svg> Task List  
                    </div>
                    <div class = "" >
                        <div class="circle circle-task shadow"><?=$TaskList ?></div>
                    </div>
                </div>
            </div>
            
            <a href='PendingTaskList.php?Type=<?=$Type ?>'   style='color:white;text-decoration:none; mt-5'>
                <div class="card-footer circle-task  text-center " id = "card-footer"  >
                    <strong>
                        Follow Daily Task List 
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </strong>
                </div>
            </a> 
        </div> <!-- END OF CARD  -->
    </div>  <!-- END OF COL   -->  

    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="card pendingQ-bg  shadow">
            <div class="card-body pb-3 pt-3"  >
                <div class= "d-flex justify-content-between">
                    <div class = "fs-2 text-white" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="40" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                      <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                      <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                    </svg>
                    Quotation
                        </div>
                    <div class = "" >
                        <div class="circle circle-Quotation  shadow"><?= $Quotation['QUOTATION'] ?></div>
                    </div>
                </div>
            </div>
            <a href='PendingQuotationList.php?Type=<?=$Type ?>'   style='color:white;text-decoration:none; mt-5'>
                <div class="card-footer text-center circle-Quotation" id = "card-footer"  >
                    <strong>
                        Follow Quotation
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </strong>
                </div>
            </a> 
        </div> <!-- END OF CARD  -->
    </div>  <!-- END OF COL   -->  

    <!-- PRODUCT CARD  -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="card pendingPro-bg  shadow">
            <div class="card-body pb-3 pt-3"  >
                <div class= "d-flex justify-content-between">
                    <div class = "fs-2 text-white" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                        </svg>  Product
                        </div>
                    <div class = "" >
                        <div class="circle circle-Product shadow"><?=$Product['PRODUCT'];?></div>
                    </div>
                </div>
            </div>
            <a href='PendingProductList.php?Type=<?=$Type ?>'   style='color:white;text-decoration:none; mt-5'>
                <div class="card-footer text-center circle-Product " id = "card-footer"  >
                    <strong>
                        Follow   Product
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </strong>
                </div>
            </a> 
        </div> <!-- END OF CARD  -->
    </div>  <!-- END OF COL   -->  

  <!--  CARD  -->


  <!-- CUSTOMER CARD  -->
  <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="card pendingCus-bg   shadow">
            <div class="card-body pb-3 pt-3"  >
                <div class= "d-flex justify-content-between">
                    <div class = "fs-2 text-white" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg> Customer
                        </div>
                    <div class = "" >
                        <div class="circle circle-Customer shadow"><?= $Customer['CUSTOMER'] ?></div>
                    </div>
                </div>
            </div>
            <a href='PendingCustomerList.php?Type=<?=$Type ?>'   style='color:white;text-decoration:none; mt-5'>
                <div class="card-footer text-center circle-Customer " id = "card-footer"  >
                    <strong>
                        Follow   Customer
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </strong>
                </div>
            </a> 
        </div> <!-- END OF CARD  -->
    </div>  <!-- END OF COL   -->  
  <!-- CUSTOMER CARD  -->


  <!-- Report CARD  -->
  <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-3">
        <div class="card report-bg   shadow">
            <div class="card-body pb-3 pt-3"  >
                <div class= "d-flex justify-content-between">
                    <div class = "fs-2 text-white" >
                     


                    <svg width="40" height="40" viewBox="0 0 220 246" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_20_12)">
                        <line y1="121" x2="233" y2="121" stroke="white" stroke-width="15"/>
                        <path d="M77 65V65C77 56.7157 83.7157 50 92 50H138C146.284 50 153 56.7157 153 65V65" stroke="white" stroke-width="15"/>
                        <path d="M78 177V177C78 168.716 84.7157 162 93 162H139C147.284 162 154 168.716 154 177V177" stroke="white" stroke-width="15"/>
                        </g>
                        <rect x="4" y="4" width="212" height="238" rx="21" stroke="white" stroke-width="15"/>
                        <defs>
                        <clipPath id="clip0_20_12">
                        <rect width="220" height="246" rx="25" fill="white"/>
                        </clipPath>
                        </defs>
                    </svg> Report



                        </div>
                    <div class = "" >
                        <div class="circle circle-Report shadow">456</div>
                    </div>
                </div>
            </div>
            <a href='FollowUpReport.php?Type=<?=$Type ?>'   style='color:white;text-decoration:none; mt-5'>
                <div class="card-footer text-center circle-Report " id = "card-footer"  >
                    <strong>
                        Generate Report 
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </strong>
                </div>
            </a> 
        </div> <!-- END OF CARD  -->
    </div>  <!-- END OF COL   -->  
  <!-- Report CARD  -->


</div> <!-- END OF ROW   -->  

</div><!-- CARD BODY-->
</div><!-- CARD -->
 
<?php  require_once '../App/partials/Footer.inc'; ?>



 