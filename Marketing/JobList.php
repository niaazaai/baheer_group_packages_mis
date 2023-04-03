 <!-- Starting area of back-end logic-->
 <?php 
    ob_start();
    require_once '../App/partials/Header.inc';   
    require_once '../App/partials/Menu/MarketingMenu.inc';  
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/JOB_LIST';
      
    if(!in_array( $Gate['VIEW_JOB_LIST'] , $_SESSION['ACCESS_LIST']  )) {
      header("Location:index.php?msg=You are not authorized to access this page!" );
    }

    require_once '../Assets/Zebra/Zebra_Pagination.php';
    require '../Assets/Carbon/autoload.php';
    use Carbon\Carbon;
 
    $pagination = new Zebra_Pagination();
    $RECORD_PER_PAGE = 15;

    $DEFAULT_COLUMNS = "CTNId,JobNo , CustId, offesetp , flexop,   CTNOrderDate,ppcustomer.CustName,ProductName, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size  , CTNQTY,CTNPrice, CTNStatus,CtnCurrency, DesignCode1,DesignImage "; 
    $DEFAULT_TABLE_HEADING = '<th>#</th><th>Q-No</th><th>Job No</th><th>order-Date</th><th>Company</th><th>Product</th><th>Size(LxWxH) (cm)</th>   <th>Order Qty</th><th>Unit Price</th><th>Status</th>  <th>R Days</th> <th>OPS</th>'; 
    $COLUMNS = ''; 
    $TABLE_HEADING = ''; 
 
  if(isset($_POST["CustId"]) && !empty($_POST["CustId"]) ){
      $CustId=$_POST['CustId'];
      $Query="SELECT DISTINCT $DEFAULT_COLUMNS FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId = carton.CTNId WHERE JobNo != 'NULL'  AND CTNStatus != 'Completed' AND CTNStatus != 'Cancel' AND 
      ppcustomer.CustId = ? AND  CTNStatus != 'Prospect'  AND  
      CTNStatus != 'Cancel'   AND  CTNStatus != 'Pending' AND  
      CTNStatus != 'Pospond'  AND  CTNStatus != 'InActive'  
      order by CTNOrderDate ASC";
      $DataRows  = $Controller->QueryData($Query, [$CustId]);
  } 
  else if (isset($_POST["Search_input"]) && !empty($_POST["Search_input"])) {
      $JobNo=$_POST['Search_input'];
      $Query="SELECT DISTINCT $DEFAULT_COLUMNS
      FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId = carton.CTNId WHERE 
      JobNo != 'NULL'   AND carton.JobNo = ?  
      order by CTNOrderDate ASC";
      $DataRows  = $Controller->QueryData($Query, [$JobNo]);
  }  else {

        $Query="SELECT DISTINCT $DEFAULT_COLUMNS
        FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId = carton.CTNId WHERE
            JobNo != 'NULL'  AND  CTNStatus != 'Completed' AND  CTNStatus != 'Prospect'  AND  CTNStatus != 'Cancel'  
            AND  CTNStatus != 'Pending' AND  CTNStatus != 'Pospond'  AND  CTNStatus != 'InActive'  order by CTNOrderDate ASC";
        $DataRows  = $Controller->QueryData($Query, []);
  }
    $FileAddress = pathinfo(__FILE__);  
?>
<!-- Ending area of back-end logic -->


<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class= "btn btn-outline-primary btn-sm " href="index.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
              </svg>
            </a>     
            <svg width="30" height="30" viewBox="0 0 60 59" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0V59H60V0H0ZM58 57H2V2H58V57Z" fill="black"/>
            <path d="M15 19C17.757 19 20 16.757 20 14C20 11.243 17.757 9 15 9C12.243 9 10 11.243 10 14C10 16.757 12.243 19 15 19ZM15 11C16.654 11 18 12.346 18 14C18 15.654 16.654 17 15 17C13.346 17 12 15.654 12 14C12 12.346 13.346 11 15 11Z" fill="black"/>
            <path d="M15 35C17.757 35 20 32.757 20 30C20 27.243 17.757 25 15 25C12.243 25 10 27.243 10 30C10 32.757 12.243 35 15 35ZM15 27C16.654 27 18 28.346 18 30C18 31.654 16.654 33 15 33C13.346 33 12 31.654 12 30C12 28.346 13.346 27 15 27Z" fill="black"/>
            <path d="M15 51C17.757 51 20 48.757 20 46C20 43.243 17.757 41 15 41C12.243 41 10 43.243 10 46C10 48.757 12.243 51 15 51ZM15 43C16.654 43 18 44.346 18 46C18 47.654 16.654 49 15 49C13.346 49 12 47.654 12 46C12 44.346 13.346 43 15 43Z" fill="black"/>
            <path d="M25 15H48C48.552 15 49 14.553 49 14C49 13.447 48.552 13 48 13H25C24.448 13 24 13.447 24 14C24 14.553 24.448 15 25 15Z" fill="black"/>
            <path d="M25 31H48C48.552 31 49 30.553 49 30C49 29.447 48.552 29 48 29H25C24.448 29 24 29.447 24 30C24 30.553 24.448 31 25 31Z" fill="black"/>
            <path d="M25 47H48C48.552 47 49 46.553 49 46C49 45.447 48.552 45 48 45H25C24.448 45 24 45.447 24 46C24 46.553 24.448 47 25 47Z" fill="black"/>
            </svg>

            Customer Job List &nbsp; <span style= "color:#FA8b09;" > <?php if( isset($_REQUEST['CustomerName'])  && !empty($_REQUEST['CustomerName'])) echo '( ' .  $_REQUEST['CustomerName'] . ' )';   ?>   </span>
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <span class= "badge" style = "background-color:#0dcaf0 ;" >NONE</span>
            <span class= "badge" style = "background-color:#6610f2;" >FLEXO </span>
            <span class= "badge" style = "background-color:#dc3545 ;" >OFFSET</span>
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 
<!-- Start of second Top Head Card which has dropdown and search functioanlity-->
<div class="card m-3 shadow"> <!-- start of the card div -->
   <div class="card-body "><!-- start of the card-body div -->
        <form action="" method="POST">
	        <div class="row"> <!-- div row tag start -->
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="z-index: 11">		

              <label for="customer" class="fw-bold"> Search Customer Here </label>
              <input type="text" name = "CustomerName" id = "customer" class="form-control " autocomplete="off"  
               onclick= "HideLiveSearch()"   onkeyup="AJAXSearch(this.value)" value = "" placeholder = "Anything"   >
              <div  id="livesearch" class="list-group shadow z-index-2 position-absolute   w-25 "></div>
              <input type="hidden" name="CustId" id = "CustId"  value = "">
            
		        </div>
            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 ms-0 "> <!-- starting tag of div search -->
              <form action="post"> 
                <button type="submit"  class = "btn btn-outline-primary mt-4 " >ALL</button>
              </form>
            </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 " > <!-- starting tag of div search -->
                  
                  <form action="" method = "post"  >
                    <label for="Search_input" class="fw-bold"> Search Order Here</label>
                    <input type="text" class= "form-control  " name = "Search_input"  autocomplete="off" id = "Search_input" placeholder = "Anything Here"  onkeyup="search( this.id , 'OrderTable' )" >  
                  </form>
                </div> <!-- Ending tag of div search -->
	        </div><!-- End Tag of div row -->
        </form>
    </div> <!-- End of the card-body div -->
</div><!-- End of the card div -->
<!-- End of second Top Head Card which has dropdown and search functioanlity-->

<!-- Start body of table Card -->
<div class="card m-3 shadow"> <!-- Start tag of card div -->
    <div class="card-body table-responsive   "><!-- start of table div -->
 
        <input type="hidden" name="Address" value = "<?= $FileAddress['filename']?>" >
        <input type="hidden" name="CustId" id = "InputCustId" value = "" > 
        <table class="table " id="OrderTable">
            <thead class="table-info"><tr> <?php if(isset($DEFAULT_TABLE_HEADING)) echo $DEFAULT_TABLE_HEADING ;  ?></tr> </thead>
            <tbody>
                <?php  $counter = 1; 

                if ($DataRows->num_rows > 0) {
                    foreach ($DataRows as $RowsKey => $Rows) {
                        $OrderDate = strtotime($Rows['CTNOrderDate']);
                        $CurrentDate = time();
                        $TimeLeft = $CurrentDate - $OrderDate ;
                        $DaysLeft = round((($TimeLeft/24)/60)/60);


                        echo "<tr>";
                        ?> 
                                        <td><?=$counter?></td>
                                        <td><?= $Rows['CTNId']  ?> </td>
                                        <td><?= $Rows['JobNo']  ?> </td>
                                        <td><?= $Rows['CTNOrderDate']  ?> </td>
                                        <td><?= $Rows['CustName']  ?> </td>
                                        <td><?= $Rows['ProductName']  ?> </td>
                                        <td><?= $Rows['Size']  ?> </td>
                                        <td><?= number_format($Rows['CTNQTY'])?> </td>
                                        <td class = "text-end"  ><?php
                                              if($Rows['CtnCurrency']=='AFN')
                                              {
                                                  echo  number_format( $Rows['CTNPrice'] , 2 ) .  " <span class='badge bg-warning'  >".   $Rows['CtnCurrency'] ." </span>"; 
                                              } 
                                              elseif($Rows['CtnCurrency']=='USD')
                                              {
                                                  echo  number_format( $Rows['CTNPrice'] , 3 ) .  " <span class='badge bg-warning' >".   $Rows['CtnCurrency'] ." </span>"; 
                                              }
                                              ?> 
                                        </td>
                                        <td><?= $Rows['CTNStatus']  ?> </td>
                                         
                                        <td> 
                                            <?php

                                              $class = "#0dcaf0";
                                              $offset_flexo = '';
                                              if ($Rows['offesetp'] == 'Yes' && $DaysLeft >= 15) {
                                                  $class = '#dc3545';
                                              } elseif ($Rows['flexop'] == 'Yes' && $DaysLeft >= 10) {
                                                  $class = '#6610f2';
                                              }

                                              $a =  Carbon::createFromTimeStamp(strtotime($Rows['CTNOrderDate']))->diffForHumans();
                                              echo "<span class = ' badge' style = 'background-color: " . $class .  "'>" . $a . "    </span>" ;
                                            ?>

                                        </td>

                        <td>  
                          <?php  if(in_array( $Gate['VIEW_JOB_CARD_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                            <a class="text-primary Py-1 my-1 " href="../Finance/JobCard.php?CTNId=<?=$Rows['CTNId'];?>&ListType=JobList" title="View Job Card" style ="text-decoration:none;" >  
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="#20c997" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.68878 18.5713L6.42858 23.3111V18.5713H1.68878Z" fill="#20c997"></path>
                                    <path d="M15.3725 10.0308H14.3265V11.592H15.3725C15.9031 11.592 16.3367 11.2399 16.3367 10.8114C16.3367 10.3828 15.9031 10.0308 15.3725 10.0308Z" fill="#20c997"></path>
                                    <path d="M9.99489 11.5919C10.5105 11.5919 10.9286 10.6553 10.9286 9.50004C10.9286 8.34475 10.5105 7.4082 9.99489 7.4082C9.47924 7.4082 9.06122 8.34475 9.06122 9.50004C9.06122 10.6553 9.47924 11.5919 9.99489 11.5919Z" fill="#20c997"></path>
                                    <path d="M15.3725 7.41309H14.3265V8.97431H15.3725C15.9031 8.97431 16.3367 8.62227 16.3367 8.1937C16.3367 7.76002 15.9031 7.41309 15.3725 7.41309Z" fill="#20c997"></path>
                                    <path d="M0 0V17.1633H7.14286C7.52041 17.1633 7.83674 17.4796 7.83674 17.8571V25H25V0H0ZM6.68367 10.801C6.68367 11.8163 5.66327 12.6429 4.40816 12.6429C3.15306 12.6429 2.13265 11.8163 2.13265 10.801V10.7041C2.13265 10.4133 2.42347 10.1786 2.78061 10.1786C3.13776 10.1786 3.42857 10.4133 3.42857 10.7041V10.801C3.42857 11.2347 3.86735 11.5918 4.40306 11.5918C4.93878 11.5918 5.37755 11.2347 5.37755 10.801V6.88776C5.37755 6.59694 5.66837 6.36224 6.02551 6.36224C6.38265 6.36224 6.67347 6.59694 6.67347 6.88776V10.801H6.68367ZM9.9949 12.6429C8.7602 12.6429 7.7602 11.2347 7.7602 9.5C7.7602 7.76531 8.7602 6.35714 9.9949 6.35714C11.2296 6.35714 12.2296 7.76531 12.2296 9.5C12.2296 11.2347 11.2296 12.6429 9.9949 12.6429ZM17.6378 10.8112C17.6378 11.8214 16.6224 12.6429 15.3724 12.6429H13.6786C13.3214 12.6429 13.0306 12.4082 13.0306 12.1173V9.5051C13.0306 9.5051 13.0306 9.5051 13.0306 9.5C13.0306 9.5 13.0306 9.5 13.0306 9.4949V6.88776C13.0306 6.59694 13.3214 6.36224 13.6786 6.36224H15.3724C16.6224 6.36224 17.6378 7.18367 17.6378 8.19388C17.6378 8.70408 17.3776 9.16837 16.9541 9.5051C17.3776 9.83674 17.6378 10.301 17.6378 10.8112ZM20.6071 12.6429C19.9847 12.6429 19.3827 12.4337 18.9592 12.0663C18.7143 11.8571 18.7245 11.5204 18.9847 11.3214C19.2449 11.1224 19.6582 11.1327 19.9031 11.3418C20.0867 11.5 20.3367 11.5867 20.6071 11.5867C21.1378 11.5867 21.5714 11.2347 21.5714 10.8061C21.5714 10.3776 21.1378 10.0255 20.6071 10.0255C19.3571 10.0255 18.3418 9.20408 18.3418 8.18878C18.3418 7.17857 19.3571 6.35204 20.6071 6.35204C21.2296 6.35204 21.8316 6.56122 22.2551 6.92857C22.5 7.13776 22.4898 7.47449 22.2296 7.67347C21.9694 7.87245 21.5561 7.86225 21.3112 7.65306C21.1276 7.4949 20.8776 7.40816 20.6071 7.40816C20.0765 7.40816 19.6429 7.7602 19.6429 8.18878C19.6429 8.61735 20.0765 8.96939 20.6071 8.96939C21.8571 8.96939 22.8724 9.79082 22.8724 10.8061C22.8724 11.8214 21.852 12.6429 20.6071 12.6429Z" fill="#20c997"></path>
                                </svg>
                            </a>
                          <?php } ?> 
                          <?php  if(in_array( $Gate['VIEW_EDIT_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                              <a class="text-primary Py-1 my-1 " href="QuotationEdit.php?Page=JobList&CTNId=<?=$Rows['CTNId'];?>  " title="Edit Quotation" style ="text-decoration:none;" >  
                                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                  </svg>
                              </a>
                          <?php } ?> 

                          <?php if(isset($Rows['DesignImage']) && !empty($Rows['DesignImage']) )  { ?>
                            <a class = "" style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                href="../Design/ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                    <svg width = "35px" height = "35px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000"></path> </g></svg>
                            </a>
                          <?php } else {  echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                          </svg>'; }  ?>

                        </td>
                     <?php  $counter++;
                            echo "</tr>";
                }  # end of   loop
            } // end of num rows if blokc 
            else echo "<tr><td colspan = '11' class = 'fw-bold text-danger text-center' >No Records Found Yet</td></tr>";
                ?>
            </tbody>
            </table>
          <?php  $pagination->render(); ?>
	 
    </div><!-- End of table div -->
</div> <!-- End tag of card div -->
<!-- Start body of table Card -->
 

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
 
     







// Get the input field
var input = document.getElementById("Search_input");

// Execute a function when the user presses a key on the keyboard
input.addEventListener("keypress", function(event) {
  // If the user presses the "Enter" key on the keyboard
  if (event.key === "Enter") {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    // document.getElementById("myBtn").click();
    
    if(input.value != '') {
      input.form.submit(); 
    }
  }
});

function AJAXSearch(str) {
      document.getElementById('livesearch').style.display = '';
    if (str.trim().length === 0) {
      return false;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200)  {
                var response = JSON.parse(this.responseText);
                var html = ''; 
                    if(response !=  '-1'){
                      for(var count = 0; count < response.length; count++) {
                                  html += '<a href="#" onclick = "PutTheValueInTheBox( `' + response[count].CustName + '`   , ' + response[count].CustId + ')"  class="list-group-item list-group-item-action" aria-current="true">' ; 
                                  html += response[count].CustName; 
                                  html += '   </a>';
                      }
                    }
                    else html += '<a href="#" class="list-group-item list-group-item-action " aria-current="true"> No Match Found</a> ';
                    document.getElementById('livesearch').innerHTML = html;  
          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
}


function HideLiveSearch()
{ document.getElementById('livesearch').style.display = 'none'; }

function PutTheValueInTheBox(inner , id)
{
    let a = document.getElementById('customer').value = inner;
    document.getElementById('customer').value = inner;
    document.getElementById('livesearch').style.display = 'none';
    document.getElementById('CustId').value = id; 
    document.getElementById('customer').form.submit();
}



 
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>

 