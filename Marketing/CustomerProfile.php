<?php    
ob_start();

require_once '../App/partials/Header.inc';  
require_once '../App/partials/Menu/MarketingMenu.inc';  
$Gate = require_once  $ROOT_DIR . '/Auth/Gates/CUSTOMER_PROFILE';
  
if(!in_array( $Gate['VIEW_CUSTOMER_PROFILE'] , $_SESSION['ACCESS_LIST']  )) {
  header("Location:index.php?msg=You are not authorized to access this page!" );
}


if (filter_has_var(INPUT_GET, 'id') && !empty($_GET['id']) ) {

  $ID = $Controller->CleanInput($_GET['id']);

  $DataRows  = $Controller->QueryData("SELECT ppcustomer.CustId,  ppcustomer.CustName,ppcustomer.CustCatagory,
  ppcustomer.BusinessType,ppcustomer.BusinessNature,ppcustomer.Timelimit,
        ppcustomer.CustContactPerson,ppcustomer.CustWorkPhone,ppcustomer.CustMobile,ppcustomer.CmpWhatsApp,ppcustomer.CustEmail,
        ppcustomer.CustWebsite,ppcustomer.CustAddress,ppcustomer.AgencyName,ppcustomer.CusStatus,ppcustomer.FollowupResponsible, ppcustomer.CusReference,
        employeet.EId,employeet.Ename,ppcustomer.CusSpecification FROM ppcustomer LEFT JOIN employeet ON employeet.EId=ppcustomer.FollowupResponsible  
        WHERE CustId = ?", [$ID]);
if($DataRows->num_rows > 0 ){
    $Customer = $DataRows->fetch_assoc();

  }

  # DEFAULT SIDE CUSTOMER DATA QUERY 
  $DataRows = $Controller->QueryData("SELECT CustId , CustName , AgencyName FROM ppcustomer ORDER BY CustId DESC LIMIT 15 " , []);
  
}  
else die("ID Not Found, This incident will be reported! ");

?> 

<style>
   .search{
       position: relative;
       box-shadow: 0 0 40px rgba(51, 51, 51, .1);
       }

       .search input{
        height: 50px;
        text-indent: 35px;
        border: 2px solid #d6d4d4;
       }


       .search input:focus{
        box-shadow: none;
        border: 2px solid #0d6efd;
       }
       .search .fa-search{
        position: absolute;
        top: 11px;
        left: 16px;
        color:gray;
        -moz-transform: scale(-1, 1);
        -webkit-transform: scale(-1, 1);
        -o-transform: scale(-1, 1);
        -ms-transform: scale(-1, 1);
        transform: scale(-1, 1);
       }
       .bg-orange {
        background-color:#fd7e14; 
       }   
       .bg-pink {
        background-color:#6610f2; 
       }  
       .blink {
          animation: blink 2s steps(1, end) infinite;
        }

        .hover-dp:hover{
          cursor: pointer;
        }



        /* .hover-dp { */
          /* padding: 0.5em 0.5em;
          background: linear-gradient(to left, white 50%, #1CD6CE 50%) right; */
          /* border-radius:3px; 
          background-size: 400%;
          transition: .2s ease-out; */
        /* } */

        .hover-dp:hover {
            width:30px ; 
            height: 30px; 
            transition: .2s ease-out;    
        }

        .highlight-tr {
          background-color:#ffff66;
          opacity:0.8;
          color:black;
          font-weight:bold;
        }

        
        /* <em class="Highlight" style="padding: 1px; box-shadow: #e5e5e5 1px 1px; 
        border-radius: 3px; -webkit-print-color-adjust: exact; background-color: #ffff66; color: #000000; font-style: inherit;"> color </em> */

        @keyframes blink{
            0%{     opacity:1;     }
            50%{    opacity:0;     }
            100%{   opacity: 1;    }
        }
</style>

  
<div class="card m-3">
  <div class="card-body d-flex justify-content-between  align-items-center ">
    <!-- LEFT TITLE AND BADGES  PAGE CARD  -->
    <?php  

      switch ($Customer['CusStatus']) {
        case 'InActive':
          $ClassName = 'bg-danger'; $Status = "In Active ";
          break;
        case 'Active':
          $ClassName = 'bg-success';  $Status = "Active";
          break;
        case 'Prospect':
          $ClassName = 'bg-warning';  $Status = "Prospect";
          break;
        case 'Pending':
          $ClassName = 'bg-info'; $Status = "Pending ";
          break;
        default:
          $ClassName = ' ';
          break;
      }
    ?>
    <div>
      <strong  class= "h2" > <?php echo $Customer['CustName']; ?>     
      </strong> <span class = "fs-6  " style = "color:#F86D09" > <?= "( " . $Customer['CusSpecification'] . " )";?>  </span>
      <span class="badge fw-bold  <?= $ClassName ?> "><?=  $Status  ?> </span>
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
          <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
        </svg>
        Customer Profile 
      </div>
    </div>
    <!-- LEFT TITLE AND BADGES  PAGE CARD  -->
     
    <!-- RIGHT BUTTONS PAGE CARD  -->
    <div>

   
    <?php  if(in_array( $Gate['CUSTOMER_PROFILE_ADD_CUSTOMER'] , $_SESSION['ACCESS_LIST']  )) { ?> 
      <a href=" CustomerRegistrationForm.php" class = "btn btn-outline-primary  my-1"  title = "New Customer" >  
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
          <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
        </svg> 
        Add Cust 
      </a>
    <?php } ?> 

    <?php  if(in_array( $Gate['CUSTOMER_PROFILE_FOLLOW_UP'] , $_SESSION['ACCESS_LIST']  )) { ?> 
      <a href="<?php if($Customer['CusStatus']=='Pending' || $Customer['CusStatus']=='Prospect'){echo "CustomerFollowUpForm.php?id=". $Customer['CustId'] ."&Address=PendingCustomerList&Type=Individual";} 
      elseif($Customer['CusStatus']=='InActive'){     echo "CustomerFollowUpForm.php?id=". $Customer['CustId'] ."&Address=PendingCustomerList&Type=General";} ?>" class = "btn btn-outline-primary  my-1 
      <?php if($Customer['CusStatus']=='Active') echo"disabled"; ?>"  title = "Follow UP " >  
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
          <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
          <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
        </svg>
        Follow  
      </a>
    <?php } ?> 

    <?php  if(in_array( $Gate['CUSTOMER_PROFILE_NEW_QUOTATION'] , $_SESSION['ACCESS_LIST']  )) { ?> 
      <a class="   btn btn-outline-primary  my-1 "     href="Quotation.php?CustId=<?=$Customer['CustId']?>"  title = "New Quotation">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-clipboard2-plus" viewBox="0 0 16 16">
          <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"/>
          <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"/>
          <path d="M8.5 6.5a.5.5 0 0 0-1 0V8H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V9H10a.5.5 0 0 0 0-1H8.5V6.5Z"/>
        </svg>
        New Quot
      </a>
    <?php } ?> 


      <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary my-1 ms-1" title = "Click to Read the User Guide " >
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
				<path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
				<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
				<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
			</svg>
			</a>
    </div>
    <!-- RIGHT BUTTONS PAGE CARD  -->
 
  </div>
</div>



<div class="row m-0 p-0">
  <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 ">
      <div class="card ">
        <div class="card-header ">
            <form >
              <div class="search  ">
                <i class="fa-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg>
                </i>
                <input type="text" class="form-control" id="search"  placeholder="Search Customer Names" onkeyup="AJAXSearch(this.value)">
              </div>


            </form>
        </div>
        <div class="card-body  ">
            <section   id = "customer_table_head"  >
            <table class="table   "><thead><tr>
            <th> #</th> <td> Customer Name  </td> 
            </tr></thead> <tbody>
            <?php 
              $counter = 1 ; 
              if ($DataRows->num_rows > 0) {
                  while ( $Cu  = $DataRows->fetch_assoc() ) {
                      echo "<tr> <td> $counter </td>"; 
                      echo  '<td><a class="  text-decoration-none" href="CustomerProfile.php?id= '. $Cu['CustId'] . '">'.   $Cu['CustName'] .'</a></td></tr>';
                      $counter++; 
                    }
                  }
            ?>
            <tbody></table > 
            </section>
        </div>
      </div>
  </div> 

  <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
  <div class="card ">
          <div class="card-body table-responsive ">

    <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
        
          <li class="nav-item" role="presentation">
            <button class="nav-link active " id="Products-tab" data-bs-toggle="tab" data-bs-target="#Products" type="button" role="tab" aria-controls="Products" aria-selected="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
              <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
            </svg> 
                Products  </button>
          </li>
          

        <li class="nav-item" role="presentation">
          <button class="nav-link" id="Polymer-tab" data-bs-toggle="tab" data-bs-target="#Polymer" type="button" role="tab" aria-controls="Polymer" aria-selected="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
            <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
            <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
          </svg>
          Polymer</button>
        </li>


        <li class="nav-item" role="presentation">
          <button class="nav-link" id="Die-tab" data-bs-toggle="tab" data-bs-target="#Die" type="button" role="tab" aria-controls="Die" aria-selected="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-aspect-ratio" viewBox="0 0 16 16">
            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
            <path d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
          </svg>  
          Die</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="Order-tab" data-bs-toggle="tab" data-bs-target="#Order" type="button" role="tab" aria-controls="Order" aria-selected="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-ruled" viewBox="0 0 16 16">
            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h7v1a1 1 0 0 1-1 1H6zm7-3H6v-2h7v2z"/>
          </svg>    
          All Order</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="Summery-tab" data-bs-toggle="tab" data-bs-target="#Summery" type="button" role="tab" aria-controls="Summery" aria-selected="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack" viewBox="0 0 16 16">
            <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z"/>
            <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z"/>
          </svg>
            All summary</button>
        </li>
         
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="About-tab" data-bs-toggle="tab" data-bs-target="#About" type="button" role="tab" aria-controls="About" aria-selected="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
            <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
            <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          </svg>
          About</button>
        </li>
      </ul>
  
      <div class="tab-content">
        <div class="tab-pane active" id="Products" role="tabpanel" aria-labelledby="Products-tab">
        <div class="card my-3">
        <div class="card-body table-responsive ">

          <div class="search mb-3">
             <i class="fa-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </i>
            <input type="text" class="form-control" id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'ProductTable' )">
          </div>

          <?php  if(in_array( $Gate['CUSTOMER_PROFILE_VIEW_PRODUCT'] , $_SESSION['ACCESS_LIST']  )) { ?> 
            <table class="table  " id = "ProductTable"  >
              <thead>
                <tr>
                    <th>#</th>   
                    <th>Product Name </th> 
                    <th> Size <span style = "font-size:10px">     (L x W x H) mm  </span> </th>
                    <th> Used Paper </th>
                    <th> Type </th>
                    <th class="text-end"> Ex-Rate </th>
                    <th class="text-end"> Grade </th>
                    <th class="text-end"> M.Usage</th>
                    <th class="text-center"> Unit Price</th>
                    <th>Poly & Die</th>
                    <!-- <th class="text-start">Design</th> -->
                    <th> Status</th>
                    <th>OPS</th>
                </tr>
              </thead>
              <tbody >
              <?php
                      $ProductQuery = "SELECT carton.CTNId  , ppcustomer.CustName,JobNo,CTNOrderDate,CTNStatus,CTNStatusDate,CTNQTY,CTNUnit,ProductName,CONCAT( CTNLength , ' x ', CTNWidth , ' x ' , CTNHeight ) AS Size ,
                      CTNUnit,CTNColor,ProductQTY,CTNPaper,CTNPrice, SUM(`CTNQTY`) AS MonthlyUsage, GrdPrice, `Ctnp1`, `Ctnp2`, `Ctnp3`, Ctnp4,Ctnp5,Ctnp6, Ctnp7,PaperP1,PaperP2,PaperP3,PaperP4,PaperP5,PaperP6, PaperP7, 
                      PexchangeUSD,CtnCurrency,DesignImage, DesignId ,DesignCode1 ,CTNType, CTNFinishDate,PolyId , DieId  
                      FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN designinfo ON designinfo.CaId = carton.CTNId 
                      WHERE CTNId in (select MAX(CTNId) from carton WHERE JobNo != 'NULL'  AND CustId1=? GROUP BY ProductName) AND  JobNo != 'NULL'  AND CustId1=? GROUP BY ProductName  ";
                      $ProductRows = $Controller->QueryData($ProductQuery , [$ID , $ID  ]);

                    if ($ProductRows->num_rows > 0) { $counter = 1;   
                      while ($rows = $ProductRows->fetch_assoc()) :  ?>  
                      <tr class= "py-0">
                        <td><?= $counter++; ?></td>
                        <td><?= $rows['ProductName'] ?> </td>
                        <td><?= $rows['Size']?></td>
                        <td>
                          <?php
                              $arr = []; 
                              for ($index=1; $index <= 7 ; $index++) { 
                                if(empty($rows['Ctnp'.$index])) continue; 
                                $arr[] = $rows['Ctnp'.$index] . ":" . $rows['PaperP'.$index];   
                              } 
                              $arr = array_count_values($arr);
                              foreach ($arr as $key => $value) echo $key . ' '; 
                              
                              echo "<span style='font-size:13px; color:#ff6600;'> - ". $rows['CTNType'] ." Ply </span>  ";
                          ?>


                        </td>
                        <td><?= $rows['CTNUnit']; ?></td>
                        <td class="text-end"><?=$rows['PexchangeUSD']; ?></td> 
                        <td class="text-end"><?=number_format ($rows['GrdPrice'] , 2 );    ?></td>
                        <td class="text-end"><?=number_format ($rows['MonthlyUsage']) ; ?></td>

                        <td class = "text-center"  > <?=  number_format ($rows['CTNPrice'] , 2 );    ?> <span class="badge bg-warning"> <?= $rows['CtnCurrency']; ?> </span> </td> 
                        
                        
                        <!-- POLY & DIE ID COLUMN  -->
                        <td >

                            <?php if(!isset($rows['PolyId']) && !isset($rows['DieId']) ) 
                                echo '<svg  style = "color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                              </svg>';
                             ?>


                            <?php if(isset($rows['PolyId'])){ ?>
                              <span class = "  hover-dp" onclick = 'FindRelatedPolymer(<?=$rows['PolyId']?> )'  >
                              <svg width="25" height="25" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"></path>
                                  <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"></path>
                                  <path d="M188 363V149H270.267C286.084 149 299.556 152.1 310.69 158.3C321.82 164.43 330.306 172.963 336.144 183.9C342.049 194.767 345 207.306 345 221.518C345 235.729 342.013 248.267 336.04 259.135C330.067 270.002 321.414 278.466 310.077 284.526C298.811 290.587 285.168 293.617 269.148 293.617H216.711V257.358H262.02C270.506 257.358 277.499 255.861 282.994 252.865C288.561 249.8 292.702 245.586 295.418 240.222C298.198 234.788 299.592 228.553 299.592 221.518C299.592 214.412 298.198 208.212 295.418 202.918C292.702 197.554 288.561 193.409 282.994 190.483C277.431 187.488 270.371 185.99 261.817 185.99H232.086V363H188Z" fill="#B3404A"></path>
                              </svg>
                              </span>
                            <?php }   
                                
                                if( isset($rows['DieId'])){ ?>
                                  <span class = "fw-bold hover-dp"   onclick = 'FindRelatedDie(<?=$rows['DieId']?> )' >
                                  <svg width="25" height="25" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#8F7255" fill-opacity="0.85"/>
                                    <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#8F7255" fill-opacity="0.85"/>
                                    <path d="M242.307 366H164.963V147.818H242.946C264.892 147.818 283.784 152.186 299.622 160.922C315.46 169.587 327.641 182.051 336.163 198.315C344.757 214.58 349.054 234.04 349.054 256.696C349.054 279.423 344.757 298.955 336.163 315.29C327.641 331.625 315.389 344.161 299.409 352.896C283.5 361.632 264.466 366 242.307 366ZM211.092 326.476H240.389C254.026 326.476 265.496 324.061 274.8 319.232C284.175 314.331 291.206 306.767 295.893 296.54C300.652 286.241 303.031 272.96 303.031 256.696C303.031 240.574 300.652 227.399 295.893 217.172C291.206 206.945 284.21 199.416 274.906 194.587C265.602 189.757 254.132 187.342 240.496 187.342H211.092V326.476Z" fill="#8F7255" fill-opacity="0.85"/>
                                  </svg>
                                </span> 
                            <?php }  ?>  
                        
                          <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                              href="../Design/ShowDesignImage.php?Url=<?= $rows['DesignImage']?>&ProductName=<?= $rows['ProductName']?>" >
                                  
                                  <svg width = "35px" height = "35px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 4.25H6C5.27065 4.25 4.57118 4.53973 4.05546 5.05546C3.53973 5.57118 3.25 6.27065 3.25 7V17C3.25 17.7293 3.53973 18.4288 4.05546 18.9445C4.57118 19.4603 5.27065 19.75 6 19.75H18C18.7293 19.75 19.4288 19.4603 19.9445 18.9445C20.4603 18.4288 20.75 17.7293 20.75 17V7C20.75 6.27065 20.4603 5.57118 19.9445 5.05546C19.4288 4.53973 18.7293 4.25 18 4.25ZM6 5.75H18C18.3315 5.75 18.6495 5.8817 18.8839 6.11612C19.1183 6.35054 19.25 6.66848 19.25 7V15.19L16.53 12.47C16.4589 12.394 16.3717 12.3348 16.2748 12.2968C16.178 12.2587 16.0738 12.2427 15.97 12.25C15.865 12.2561 15.7622 12.2831 15.6678 12.3295C15.5733 12.3759 15.4891 12.4406 15.42 12.52L14.13 14.07L9.53 9.47C9.46222 9.39797 9.37993 9.34111 9.28858 9.30319C9.19723 9.26527 9.09887 9.24714 9 9.25C8.89496 9.25611 8.79221 9.28314 8.69776 9.32951C8.60331 9.37587 8.51908 9.44064 8.45 9.52L4.75 13.93V7C4.75 6.66848 4.8817 6.35054 5.11612 6.11612C5.35054 5.8817 5.66848 5.75 6 5.75ZM4.75 17V16.27L9.05 11.11L13.17 15.23L10.65 18.23H6C5.67192 18.23 5.35697 18.1011 5.12311 17.871C4.88926 17.6409 4.75525 17.328 4.75 17ZM18 18.25H12.6L16.05 14.11L19.2 17.26C19.1447 17.538 18.9951 17.7884 18.7764 17.9688C18.5577 18.1492 18.2835 18.2485 18 18.25Z" fill="#000000"></path> </g></svg>
                          </a>

                        </td>    


                        <td>
                            <?php 
                              $Status = ''; 
                              $color = ''; 
                              $DaysPassed = '';
                              $blink = ''; 
                              if($rows['CTNStatus'] == 'InActive' || $rows['CTNStatus'] == 'Prospect' || $rows['CTNStatus'] == 'Pending' ) {
                                    $Status = $rows['CTNStatus']; 
                                    if($rows['CTNStatus'] == 'InActive') $color = 'bg-danger'; 
                                    if($rows['CTNStatus'] == 'Prospect') $color = 'bg-orange'; 
                                    if($rows['CTNStatus'] == 'Pending') $color = 'bg-pink'; 
                                    $DaysPassed = ceil((time()  - strtotime($rows['CTNStatusDate'])) / 86400 );
                                   
                              }
                              else if( $rows['CTNStatus'] !== 'Active' ){
                                $Status = 'Active';  $color = 'bg-success'; $DaysPassed = NULL ;    
                              }
                              echo "<span class='badge fw-bold   ".  $color.  "'>  $Status $DaysPassed   </span>"; 
                            ?>  
                        </td>
                        <!-- STATUS  COLUMN   var_dump($_SESSION['ACCESS_LIST']);  -->      
                       
                        <td>
                            <?php   if(in_array( $Gate['CUSTOMER_PROFILE_REORDER'] , $_SESSION['ACCESS_LIST']  )) { ?>  
                                <!-- PROFILE  -->
                                <a  href="QuotationEdit.php?Page=CustomerProfile&CTNId=<?=$rows['CTNId'] ?>" title = "click to Reorder" > 
                                  <svg width="25" height="25" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_203_7)">
                                      <path d="M3.5 2C3.36739 2 3.24021 2.05268 3.14645 2.14645C3.05268 2.24021 3 2.36739 3 2.5V14.5C3 14.6326 3.05268 14.7598 3.14645 14.8536C3.24021 14.9473 3.36739 15 3.5 15H12.5C12.6326 15 12.7598 14.9473 12.8536 14.8536C12.9473 14.7598 13 14.6326 13 14.5V2.5C13 2.36739 12.9473 2.24021 12.8536 2.14645C12.7598 2.05268 12.6326 2 12.5 2H12C11.8674 2 11.7402 1.94732 11.6464 1.85355C11.5527 1.75979 11.5 1.63261 11.5 1.5C11.5 1.36739 11.5527 1.24021 11.6464 1.14645C11.7402 1.05268 11.8674 1 12 1H12.5C12.8978 1 13.2794 1.15804 13.5607 1.43934C13.842 1.72064 14 2.10218 14 2.5V14.5C14 14.8978 13.842 15.2794 13.5607 15.5607C13.2794 15.842 12.8978 16 12.5 16H3.5C3.10218 16 2.72064 15.842 2.43934 15.5607C2.15804 15.2794 2 14.8978 2 14.5V2.5C2 2.10218 2.15804 1.72064 2.43934 1.43934C2.72064 1.15804 3.10218 1 3.5 1H4C4.13261 1 4.25979 1.05268 4.35355 1.14645C4.44732 1.24021 4.5 1.36739 4.5 1.5C4.5 1.63261 4.44732 1.75979 4.35355 1.85355C4.25979 1.94732 4.13261 2 4 2H3.5Z" fill="#0d6efd"/>
                                      <path d="M10 0.5C10 0.367392 9.94732 0.240215 9.85355 0.146447C9.75979 0.0526784 9.63261 0 9.5 0L6.5 0C6.36739 0 6.24021 0.0526784 6.14645 0.146447C6.05268 0.240215 6 0.367392 6 0.5C6 0.632608 5.94732 0.759785 5.85355 0.853553C5.75979 0.947322 5.63261 1 5.5 1C5.36739 1 5.24021 1.05268 5.14645 1.14645C5.05268 1.24021 5 1.36739 5 1.5V2C5 2.13261 5.05268 2.25979 5.14645 2.35355C5.24021 2.44732 5.36739 2.5 5.5 2.5H10.5C10.6326 2.5 10.7598 2.44732 10.8536 2.35355C10.9473 2.25979 11 2.13261 11 2V1.5C11 1.36739 10.9473 1.24021 10.8536 1.14645C10.7598 1.05268 10.6326 1 10.5 1C10.3674 1 10.2402 0.947322 10.1464 0.853553C10.0527 0.759785 10 0.632608 10 0.5V0.5Z" fill="#0d6efd"/>
                                      <path d="M6.18141 7.76818L8.02641 5.19868C8.06218 5.13816 8.1131 5.08801 8.17416 5.05316C8.23522 5.01832 8.3043 5 8.3746 5C8.4449 5 8.51399 5.01832 8.57504 5.05316C8.6361 5.08801 8.68702 5.13816 8.72279 5.19868L10.5689 7.76818C10.6049 7.82943 10.6241 7.89913 10.6245 7.97019C10.6249 8.04125 10.6065 8.11114 10.5711 8.17278C10.5357 8.23442 10.4847 8.28561 10.4232 8.32114C10.3616 8.35668 10.2918 8.3753 10.2207 8.37512H9.50016C9.50016 9.21887 9.50016 11.7501 5.00016 12.3126C7.53141 10.9064 7.25016 8.37512 7.25016 8.37512H6.5296C6.2146 8.37512 6.02448 8.03424 6.18085 7.76818H6.18141Z" fill="#0d6efd"/>
                                    </g>
                                    <defs>
                                      <clipPath id="clip0_203_7">
                                        <rect width="16" height="16" fill="white"/>
                                      </clipPath>
                                    </defs>
                                  </svg>
                                </a>
                            <?php } ?>

                            <?php  if(!in_array( $Gate['CUSTOMER_PROFILE_ORDER_HISTORY'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                                <a href="CustomerOrderHistory.php?id=<?=$Customer['CustId'] ?>&ProductName=<?=$rows['ProductName'];?>" title = "View History" > 
                                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                  </svg>
                                </a>
                            <?php } ?>
                        </td>
                      </tr>
                    <?php endwhile;  # while loop
                } # END OF IF 
                ?>
            </tbody>
          </table>
          <?php } // END OF PERMISSION IF BLOCK 
            else { echo '<h5 class = "text-center mt-2 "> You are not authorized to access this tab </h5>'; }  
          ?>

          </div><!-- END OF CARD-BODY  -->
        </div><!--  END of card  -->
        </div><!--  END Products-tab  -->
       
        <div class="tab-pane" id="Polymer" role="tabpanel" aria-labelledby="Polymer-tab">
          <div class="card my-3">
            <div class="card-body table-responsive ">

              <div class="search mb-3">
                <i class="fa-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg>
                </i>
                <input type="text" class="form-control" id = "Polymer_Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'PolymerTable' )">
              </div>

              <?php  if(in_array( $Gate['CUSTOMER_PROFILE_VIEW_POLYMER'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                
              <table class="table " id = "PolymerTable" >
                <thead>
                  <tr>
                    <th>#</th> 
                    <th> Polymer Code</th>
                      <th> Product Name </th>  
                      <th> Size <span style = "font-size:10px">     (L x W x H) mm  </span> </th>
                      <th> Color </th>
                      <th> Made By </th>
                      <th> Owner </th>
                      <th> Design Code</th>
                      <th> Sample Code</th>
                      <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php

                  $PolymerQuery="SELECT ppcustomer.CustId,cpolymer.PColor,cpolymer.PSize,cpolymer.PMade,cpolymer.POwner, 
                  cpolymer.DesignCode , cpolymer.CPid, cpolymer.ProductName AS PolymerProductName,cpolymer.CartSample , cpolymer.PStatus
                  FROM cpolymer INNER JOIN ppcustomer ON ppcustomer.CustId=cpolymer.CompId   WHERE   CustId = ? ORDER BY CPid DESC";
                  $ProductRows = $Controller->QueryData($PolymerQuery , [$ID]);

                  // old query for finding a polymer 
                  // $PolymerQuery="SELECT 
                  // ppcustomer.CustId,cpolymer.PColor,cpolymer.PSize,cpolymer.PMade,cpolymer.POwner, 
                  // cpolymer.DesignCode , cpolymer.CPid, cpolymer.ProductName AS PolymerProductName,cpolymer.CartSample,carton.CustId1,carton.JobNo
                  // FROM cpolymer INNER JOIN ppcustomer ON ppcustomer.CustId=cpolymer.CompId INNER JOIN carton ON carton.CustId1=ppcustomer.CustId WHERE  JobNo!='NULL' AND CustId = ?";
                  // $ProductRows = $Controller->QueryData($PolymerQuery , [$ID]);



                  if ($ProductRows->num_rows > 0) {   $counter = 1;  
                    
                    foreach ($ProductRows as $key => $value) : ?>  
                        <tr id = "polymer_tab_tr_<?= $value['CPid']; ?>" >
                        <td><?=$counter++; ?></td>
                        <td><?= $value['CPid']; ?></td>
                          <td><?= $value['PolymerProductName']; ?></td>
                          <td><?= $value['PSize']  ?></td>
                          <td><?= $value['PColor']  ?></td> 
                          <td><?= $value['PMade']; ?></td>
                          <td><?= $value['POwner']; ?></td>
                          <td class = "<?php if(!isset($value['DesignCode'])) echo "bg-danger text-white"  ?>" ><?= $value['DesignCode']; ?></td>
                          <td class = "<?php if(!isset($value['CartSample'])) echo "bg-danger text-white"  ?>" ><?= $value['CartSample']; ?></td>

                          <td> <span class = "badge <?= ($value['PStatus'] == 'Damage') ? 'bg-danger': 'bg-success' ; ?> " > 
                          <?=$value['PStatus']  ?> </span> </td>
                       

 
                        </tr>
                      <?php endforeach;  # while loop
                  } # END OF IF 
                  ?>
              </tbody>
            </table>

              <?php } // END OF PERMISSION IF BLOCK 
                else { echo '<h5 class = "text-center mt-2 "> You are not authorized to access this tab </h5>'; }  
              ?>
          

            </div><!-- END OF CARD-BODY  -->
          </div><!--  END of card  -->
        </div><!--  END Polymer-tab  -->
 




      







        <div class="tab-pane" id="Die" role="tabpanel" aria-labelledby="Die-tab">
        <div class="card my-3">
          <div class="card-body table-responsive ">
           
              <div class="search mb-3">
                <i class="fa-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg>
                </i>
                <input type="text" class="form-control" id = "Die_Search_Input" placeholder="Search Anything " onkeyup="search( this.id , 'DieTable' )">
              </div>          
                <?php  if(in_array( $Gate['CUSTOMER_PROFILE_VIEW_DIE'] , $_SESSION['ACCESS_LIST']  )) { ?>  
                  <table class="table" id = "DieTable" >
                    <thead>
                      <tr>
                          <th> # </th>
                          <th> Die Code</th>
                          <th> Product Name </th>
                          <th> Size <span style = "font-size:10px">     (L x W x H) mm  </span>  </th>
                          <th> App </th>
                          <th>Die Type</th>
                          <th> Made By </th>
                          <th> Owner </th>
                          <th> Sketch</th>
                          <th>Sample Code </th>
                          <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                    $ProductRows = $Controller->QueryData(" SELECT ppcustomer.CustId, cdie.CDProductName , cdie.CDSize , cdie.CDMade , cdie.CDOwner ,
                    cdie.CDDesignCode , cdie.CDSampleNo , cdie.CDieId , cdie.CDDesignCode ,  cdie.App , cdie.DieType , cdie.Scatch ,cdie.CDStatus
                    FROM cdie INNER JOIN ppcustomer ON ppcustomer.CustId=cdie.CDCompany  WHERE ppcustomer.CustId= ?  ORDER BY CDieId DESC " , [$ID]);

                      if ($ProductRows->num_rows > 0) {   $counter = 1;  
                        foreach ($ProductRows as $key => $value) : ?>  
                            <tr id= 'die_tab_tr_<?= $value['CDieId']; ?>'>
                              <td><?=$counter++; ?></td>
                              <td><?= $value['CDieId']; ?></td>
                              <td> <?= $value['CDProductName']; ?></td>
                              <td>   <?= $value['CDSize']  ?></td>
                              <td>   <?= $value['App']  ?> </td>
                              <td>   <?= $value['DieType']  ?> </td>
                              <td><?= $value['CDMade']; ?></td>
                              <td><?= $value['CDOwner']; ?></td>
                              <!-- <td class = "<?php if(!isset($value['CDDesignCode'])) echo "bg-danger text-white"  ?>" ><?php if(isset($value['CDDesignCode'])) echo $value['CDDesignCode']; else echo 'No Design' ?></td> -->
                              <!-- ../Assets/ArchiveSketch/$value['Scatch'] -->
                              
                              <td   >  
                                <?php 

                                if(isset($value['Scatch']) && !empty($value['Scatch']) ) {

                                    echo '
                                    <a href="ShowSketchImage.php?Url=ArchiveSketch/'. $value['Scatch']  .'&ProductName='. $value['CDProductName']  .' "> <svg width="25" height="25" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M60 37V1C60 0.4 59.6 0 59 0H1C0.4 0 0 0.4 0 1V48C0 48.6 0.4 49 1 49H11V47H2V2H58V36H48C47.4 36 47 36.4 47 37V47H25V49H48C48.3 49 48.5 48.9 48.7 48.7L59.7 37.7C59.8 37.6 59.8 37.5 59.9 37.4V37.3C60 37.2 60 37.1 60 37ZM49 38H56.6L52.8 41.8L49 45.6V38Z" fill="black"/>
                                        <path d="M18.9 9.7C18.8 9.3 18.4 9 18 9C17.6 9 17.2 9.3 17.1 9.7L14.2 18.4C14.1 18.6 14 18.8 14 19V52V59C14 59.6 14.4 60 15 60H21C21.6 60 22 59.6 22 59V52V19C22 18.8 21.9 18.5 21.8 18.4L18.9 9.7ZM16 20H17V51H16V20ZM19 20H20V51H19V20ZM18 13.2L19.6 18H16.4L18 13.2ZM20 58H16V53H17H19H20V58Z" fill="black"/>
                                        <path d="M35 6C30 6 26 10 26 15V17H28V15C28 11.1 31.1 8 35 8C38.9 8 42 11.1 42 15V17H44V15C44 10 40 6 35 6Z" fill="black"/>
                                        <path d="M54 16V14H52V16C52 19.9 48.9 23 45 23C41.1 23 38 19.9 38 16V14H36V16C36 21 40 25 45 25C50 25 54 21 54 16Z" fill="black"/>
                                        <path d="M25 33V43C25 43.6 25.4 44 26 44H36C36.6 44 37 43.6 37 43V33C37 32.4 36.6 32 36 32H26C25.4 32 25 32.4 25 33ZM27 34H35V42H27V34Z" fill="black"/>
                                        <path d="M39 35V37H41C41.6 37 42 36.6 42 36V28C42 27.4 41.6 27 41 27H33C32.4 27 32 27.4 32 28V30H34V29H40V35H39Z" fill="black"/> <path d="M8 5H6V7H8V5Z" fill="black"/> <path d="M12 5H10V7H12V5Z" fill="black"/> <path d="M16 5H14V7H16V5Z" fill="black"/> <path d="M12 9H10V11H12V9Z" fill="black"/> <path d="M8 9H6V11H8V9Z" fill="black"/> <path d="M8 13H6V15H8V13Z" fill="black"/> <path d="M8 17H6V19H8V17Z" fill="black"/> <path d="M8 21H6V23H8V21Z" fill="black"/> <path d="M8 25H6V27H8V25Z" fill="black"/> <path d="M8 29H6V31H8V29Z" fill="black"/> <path d="M8 33H6V35H8V33Z" fill="black"/> <path d="M8 37H6V39H8V37Z" fill="black"/> <path d="M8 41H6V43H8V41Z" fill="black"/>
                                        </svg> 
                                    </a>';
                                  }
                                  else {
                                    echo '  <svg  style = "color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                      </svg>';
                                  }     
                                
                                ?>
                              </td>
                              
                              <td class = "<?php if(!isset($value['CDSampleNo'])) echo "bg-danger text-white"  ?>" > <?php if(isset($value['CDSampleNo'])) echo $value['CDSampleNo']; else echo 'No Sample' ?>  </td>
                              <td class = "" > <span class = "badge <?= ($value['CDStatus'] == 'Damage') ? 'bg-danger': 'bg-success' ; ?> " > <?=$value['CDStatus']  ?> </span> </td>
                            </tr>
                          <?php endforeach;  # while loop
                      } # END OF IF 
                      ?>
                  </tbody>
                </table>
                <?php } // END OF PERMISSION IF BLOCK 
                    else { echo '<h5 class = "text-center mt-2 "> You are not authorized to access this tab </h5>'; }  
                  ?> 
          </div><!-- END OF CARD-BODY  -->
        </div><!--  END of card  -->
        </div><!--  END Die-tab  -->

        <div class="tab-pane" id="Order" role="tabpanel" aria-labelledby="Order-tab">
            <div class="card my-3">
              <div class="card-body table-responsive ">

              <div class="search mb-3">
                <i class="fa-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg>
                </i>
                <input type="text" class="form-control" id = "Order_Search_Input"  placeholder="Search Anything "  onkeyup="search( this.id , 'OrderTable' )">
              </div>

              <?php  if(in_array( $Gate['CUSTOMER_PROFILE_VIEW_ALL_ORDER'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                <table class="table " id = "OrderTable" >
                  <thead>
                    <tr>
                        <th>#</th>
                        <!-- <th>Date</th> -->
                        <th>Job No </th>
                        <th>Product Name</th>
                        <th> Size <span style = "font-size:10px">     (L x W x H) mm  </span> </th>
                        <!-- <th> Used Paper </th> -->
                        <!-- <th> Type </th> -->
                        <!-- <th> Exchange</th> -->
                        <th class="text-end"> Grade </th>
                        <th class="text-end"> Order QTY</th>
                        <th class="text-end"> Unit Price</th>
                        <th class="text-end"> Total Amount</th>
                        <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $ProductRows = $Controller->QueryData("SELECT carton.CTNOrderDate , carton.JobNo ,  carton.ProductName  , CONCAT( CTNLength , ' x ', CTNWidth , ' x ' , CTNHeight ) AS Size , 
                    carton.JobType,  carton.CTNType,  carton.CtnCurrency, carton.GrdPrice,carton.PexchangeUSD,  carton.CTNQTY,  carton.CTNPrice, 
                      carton.Ctnp1,   carton.Ctnp2 ,  carton.Ctnp3 ,  carton.Ctnp4, carton.Ctnp5, carton.Ctnp6,  carton.Ctnp7, 
                      carton.PaperP1, carton.PaperP2, carton.PaperP3, carton.PaperP4, carton.PaperP5, carton.PaperP6,  carton.PaperP7, carton.CTNType, carton.FinalTotal,  carton.CTNStatus , carton.CTNUnit
                    FROM carton inner JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  WHERE ppcustomer.CustId= ? AND JobNo != 'NULL'" , [$ID]);
                                  

                    if ($ProductRows->num_rows > 0) { $count = 1 ;
                         $OrderQTYTotal = 0 ; $AFGTotal = 0; $USDTotal = 0  ;  
                        foreach ($ProductRows as $key => $value) : ?>  
                          <tr>
                            <td><?=$count++ ?></td>
                            <!-- <td><?= $value['CTNOrderDate']; ?></td> -->
                            <td><?= $value['JobNo']; ?></td>
                            <td><?= $value['ProductName']; ?></td>
                            <td><?=$value['Size'] ?></td>
                            <!-- <td>
                            <?php
                              $arr = []; 

                              for ($index=1; $index <= 7 ; $index++) { 
                                if(empty($value['Ctnp'.$index])) continue; 
                                $arr[] = $value['Ctnp'.$index] . ":". $value['PaperP'.$index];   
                              } $arr = array_count_values($arr);

                              foreach ($arr as $ke => $val) echo  $ke . ' '; 
                              echo "<span style='font-size:13px; color:#ff6600;'> - ". $value['CTNType'] ." Ply </span>  ";
                          ?>
                            </td> -->
                            <!-- <td><?= $value['CTNUnit']; ?></td> -->
                            <!-- <td><?= $value['PexchangeUSD']; ?></td> -->
                            <td class="text-end"><?= number_format($value['GrdPrice'] ,2 ); ?></td>
                            <td  class="text-end"  ><?php echo number_format($value['CTNQTY']);  $OrderQTYTotal += $value['CTNQTY']; ?></td>
                            <td class="text-end" ><?= number_format ($value['CTNPrice'] ,2 ) ; ?></td>
                            <td  class="text-end"><?php
                                if($value['CtnCurrency'] == 'USD') $USDTotal += $value['FinalTotal'];
                                else if($value['CtnCurrency'] == 'AFN')  $AFGTotal += $value['FinalTotal'];
                                echo number_format ($value['FinalTotal'] , 2); 
                              ?>
                             <span class="badge bg-warning"> <?= $value['CtnCurrency']; ?> </span> </td> 
                            </td>
                            <td class="text-end"> <?= $value['CTNStatus']; ?></td>
                          </tr>
                        <?php endforeach;  # while loop ?>
                    <tr>
                      <td colspan = "4" class  = "text-center fw-bold" >Total </td>
                      <td colspan = "3"  class  = "text-center pe-5" > <strong > <?php echo number_format ($OrderQTYTotal  );  ?></strong>  </td>
                      <td class  = "text-end"> 
                            <strong > <?= number_format ($USDTotal , 2 ); ?> USD  </strong>  
                            <br>
                            <strong  > <?= number_format($AFGTotal,2); ?> AFN </strong>  
                      </td>
                      <td></td>
                      <td></td>
                    </tr>

                    <?php } # END OF IF 
                      else echo "<tr> <td colspan = '12' class = 'text-center'> NO RECORD FOUND <td></tr> "; 
                    ?>
                </tbody>
              </table>
              <?php } // END OF PERMISSION IF BLOCK 
                else { echo '<h5 class = "text-center mt-2 "> You are not authorized to access this tab </h5>'; }  
              ?>
              </div><!-- END OF CARD-BODY  -->
            </div><!--  END of card  -->
        </div>
 
        <div class="tab-pane" id="Summery" role="tabpanel" aria-labelledby="Summery-tab"> 
          <div class="card my-3">
                <div class="card-body table-responsive ">

                <div class="search mb-3">
                  <i class="fa-search">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                  </i>
                  <input type="text" class="form-control" id = "Summery_Search_Input"  placeholder="Search Anything "  onkeyup="search( this.id , 'SummeryTable' )">
                </div>
                <?php  if(in_array( $Gate['CUSTOMER_PROFILE_VIEW_ALL_SUMMERY'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                  <table class="table "  id = "SummeryTable"  >
                    <thead>
                      <tr>
                          <th>#</th>
                          <th>Product Name</th>
                          <th> Type </th>
                          <th class="text-end"> No of Jobs</th>
                          <th class="text-end"> Order QTY</th>
                          <th class="text-end"> Total Amount</th>
                          <th>OPS</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                            
                      $ProductRows = $Controller->QueryData("SELECT   carton.ProductName ,carton.CtnCurrency,carton.PexchangeUSD, COUNT(carton.ProductName) AS NumberOfJobs , carton.CTNUnit,carton.JobNo, 
                       SUM(carton.CTNQTY) AS OrderQuantity    ,  SUM(carton.FinalTotal) AS TotalAmount  
                      FROM carton inner JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1
                      WHERE ppcustomer.CustId= ? AND JobNo!='NULL'
                      GROUP BY carton.ProductName " , [$ID]);


                      if ($ProductRows->num_rows > 0) { $count = 1 ;
                          $ProductRows->fetch_assoc(); $OrderQTYTotal = 0 ; $ReceivedAmountTotal = 0 ; $JobTotal = 0 ; 
                          foreach ($ProductRows as $key => $value) : ?>  
                            <tr>
                              <td><?=$count++ ?></td>
                              <td> <?= $value['ProductName']; ?></td>
                              <td><?= $value['CTNUnit']; ?></td>
                              <td class="text-end"> <?= $value['NumberOfJobs'];  $JobTotal += $value['NumberOfJobs'];  ?>  </td>

                              <td class="text-end"><?php echo number_format($value['OrderQuantity']);  $OrderQTYTotal += $value['OrderQuantity']; ?></td>
                              <td class="text-end"><?php 
                              if($value['CtnCurrency']=='AFN'){  

                                 $a =  $value['TotalAmount'] / $value['PexchangeUSD'];
                                 $ReceivedAmountTotal += $a; echo number_format ( $a , 2 ) ;}
                                else{
                                  echo number_format($value['TotalAmount'],2 );
                                   $ReceivedAmountTotal += $value['TotalAmount'];
                                  } ?>
                              </td> 
                              <td>
                                  <a href="CustomerOrderHistory.php?id=<?=$Customer['CustId'] ?>&ProductName=<?=$value['ProductName'];?>" title = "View History" > 
                                      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                      </svg>
                                  </a>
                              </td>
                            </tr>
                          <?php endforeach;  # while loop ?>
                      <tr>
                        <td colspan = "3" class  = "text-center fw-bold " >Total </td>
                        <td class  = " fw-bold text-end "><?php echo $JobTotal;  ?></td>
                        <td class  = " fw-bold text-end" ><?php echo number_format($OrderQTYTotal);  ?></td>
                        <td class  = " fw-bold text-end"><?= number_format ($ReceivedAmountTotal , 2 ); ?> <span class="badge bg-warning"> USD </span> </td>
                        <td></td>
                      </tr>
                      <?php } # END OF IF 
                      else echo "<tr> <td colspan = '9' class = 'text-center'> NO RECORD FOUND <td></tr> "; 
                      ?>
                  </tbody>
                </table>
                <?php } // END OF PERMISSION IF BLOCK 
                else { echo '<h5 class = "text-center mt-2 "> You are not authorized to access this tab </h5>'; }  
              ?>
                </div><!-- END OF CARD-BODY  -->
              </div><!--  END of card  -->
        </div>
        
        
        <div class="tab-pane  <?php echo (isset($_GET['tab'])) ? 'active': ''  ?>" id="About" role="tabpanel" aria-labelledby="About-tab">
            <div class="card my-3">
              <div class="card-body  ">
                <div class="d-flex justify-content-between">
                 <h3 class = ""><?=$Customer['CustName'];?><span class = "fs-6" > ( <?=$Customer['CusSpecification'];?> )</span>  </h3> 
                 <?php  if(in_array( $Gate['CUSTOMER_PROFILE_EDIT_CUSTOMER'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                  <a class="btn btn-outline-primary  my-1"     href="CustomerEditForm.php?id=<?= $ID ?> " >  
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      </svg>
                      Edit 
                  </a>
                  <?php } ?> 
                </div>
                <hr>
                <?php  if(in_array( $Gate['CUSTOMER_PROFILE_VIEW_ABOUT'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                <table class =" table table-borderless " >
    
                      <tr>  <th colspan = 2 class = "fw-bold h3"  >
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                          <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                        </svg> Company Details</th> 
                     </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Customer Name   </td>  <td class = "fw-bold ps-4" >  <?=$Customer['CustName'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Catagory  </td>        <td class = "fw-bold ps-4" >  <?=$Customer['CustCatagory'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Business Type </td>    <td class = "fw-bold ps-4" >  <?=$Customer['BusinessType'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Business Nature </td>  <td class = "fw-bold ps-4" >  <?=$Customer['BusinessNature'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" > Time Limit </td>      <td class = "fw-bold ps-4" >  <?=$Customer['Timelimit'];?>  <hr></td> </tr>
 
                      <tr>  <th   class = "fw-bold h3" style = "border-right:3px solid black; width:20%;"  >
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                      </svg>
                      Contact Details</th> <td ></td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Contact person   </td>  <td class = "fw-bold ps-4" >  <?=$Customer['CustContactPerson'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Work Phone  </td>        <td class = "fw-bold ps-4" >  <?=$Customer['CustWorkPhone'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Mobile   </td>    <td class = "fw-bold ps-4" >  <?=$Customer['CustMobile'];?> </td> </tr>
                      <tr> <td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" > Whatsapp</td>  <td class = "fw-bold ps-4" >  <?=$Customer['CmpWhatsApp'];?> </td>  </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" > Email </td>      <td class = "fw-bold ps-4" >  <?=$Customer['CustEmail'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" > Website </td>      <td class = "fw-bold ps-4" >  <?=$Customer['CustWebsite'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" > Address </td>      <td class = "fw-bold ps-4" >  <?=$Customer['CustAddress'];?> <hr></td> </tr>
 

                      <tr>  <th   class = "fw-bold h3" style = "border-right:3px solid black; width:20%;"  > 
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                      <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                      <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
                    </svg>
                    User Details  </th> <td ></td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Agency </td>  <td class = "fw-bold ps-4" >  <?=$Customer['AgencyName'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Status  </td>        <td class = "fw-bold ps-4" >  <?=$Customer['CusStatus'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Point of Contact</td>    <td class = "fw-bold ps-4" >  <?=$Customer['CusReference'];?> </td> </tr>
                      <tr><td class = "text-end pe-3 fw-bold " style = "font-size:18px; border-right:3px solid black; width:20%;" >Follow up responsible  </td>    <td class = "fw-bold ps-4" >  <?=$Customer['Ename'];?> </td> </tr>

                </table>
                <?php } // END OF PERMISSION IF BLOCK 
                else { echo '<h5 class = "text-center mt-2 "> You are not authorized to access thi1s tab </h5>'; }  
              ?>
        </div><!-- END OF About-tab  -->
      </div><!-- END OF TAB CONTENT  -->

      </div><!-- NAV TABS END COL  -->
    </div><!-- NAV TABS END ROW  -->
    </div>
</div>
  </div>




<script>
  function AJAXSearch(str) {
    console.log(str);
    if (str.length == 0) {
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                var html = ''; 

                var customer_table_head =   '<table class="table"><thead><tr>';
                    customer_table_head += '<th> #</th> <th> Customer Name  </th>  ';
                    customer_table_head += '</tr></thead> <tbody id = "customer_table" >';
                    document.getElementById('customer_table_head').innerHTML = customer_table_head;
                    if(response !=  '-1'){
                      for(var count = 0; count < response.length; count++) {
                                  html += '<tr>';
                                  html += '<td> ' + count + '</td>'; 
                                  html += '<td><a class="text-decoration-none"  href="CustomerProfile.php?id=' + response[count].CustId + '">' + response[count].CustName +'</a></td>';
                                  html += '</tr>';
                      }
                    }
                    else html += '<tr><td colspan="3" class="text-center">No Data Found</td></tr>';
                    html += "</tbody></table>";
                    console.log(response);
                    document.getElementById('customer_table').innerHTML = html;
          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
  }
 
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






function FindRelatedDie(dieid){
 
  document.getElementById("Products").classList = 'tab-pane';
  document.getElementById("Products-tab").classList = 'nav-link';   
  document.getElementById("Die").classList = 'tab-pane active';
  document.getElementById("Die-tab").classList = 'nav-link active';   
  document.getElementById("die_tab_tr_" + dieid ).classList = 'highlight-tr';
  setTimeout(() => {
    document.getElementById("die_tab_tr_" + dieid ).classList = '';
  }, 7000);

}


function FindRelatedPolymer(CPID){
  
  document.getElementById("Products").classList = 'tab-pane';
  document.getElementById("Products-tab").classList = 'nav-link';   
  document.getElementById("Polymer").classList = 'tab-pane active';
  document.getElementById("Polymer-tab").classList = 'nav-link active';   
  document.getElementById("polymer_tab_tr_" + CPID ).classList = 'highlight-tr';
  setTimeout(() => {
    document.getElementById("polymer_tab_tr_" + CPID ).classList = '';
  }, 7000);

}


</script>








</div> <!-- END M-3 FIRST DIV IN THE PAGE  -->
<?php  require_once '../App/partials/Footer.inc'; ?>


 

