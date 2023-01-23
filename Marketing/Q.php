<?php    require_once '../App/partials/Header.inc';  ?>
<?php   require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
<?php
    // Authorization Code 
    $RowCount =  $Controller->QueryData("SELECT * FROM employeet WHERE EUserName = ?" , [$_SESSION['user']] );
    $r1 = $RowCount->fetch_row(); 
    if ($r1[0]>5 && $r1[14]!='Marketing' && $r1[0]!=92 && $r1[0]!=63  && $r1[0]==20 && $r1[0]==34)  header("Location:index.php"); // MUST REDIRECT TO CUSTOMER DASHBOARD INSTEAD OF INDEX 
 

    // CustId is Sout 
    if(isset($_POST['CustId']) && !empty($_POST['CustId'])){
      $CustId=$_POST['CustId'];
    }

    if(isset($_GET['CustId']) && !empty($_GET['CustId'])){
      $CustId=$_GET['CustId'];
    } else die('Customer ID is has not set correctly'); 

    // FOR TAKING LAST JOB-NO 
    $Customer =  $Controller->QueryData("SELECT CustId, CustName,  CustContactPerson, CustMobile, CustEmail,  CustAddress, CustWebsite, CustCatagory 
    FROM ppcustomer WHERE CustId=  ?" , [ $CustId ] );
    $Customer = $Customer->fetch_assoc(); 


    # THIS BLOCK OF CODE IS FOR RETRIVING LAST JOB NO 
    $q =  $Controller->QueryData("SELECT CTNId, CTNType, CustId1, JobNo FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where JobNo!='NULL' ORDER BY carton.`CTNId` DESC" , [] );
    $LastJobNo = $q->fetch_row(); 

 # THIS BLOCK OF CODE IS FOR RETRIVING PAPER PRICE AND NAMES FOR PLYs TO SHOW  
    $PP =  $Controller->QueryData("SELECT DISTINCT Name,Price FROM paperprice" , [] );
    $PaperPrice = []; 
    while($PaperPriceDB = $PP->fetch_assoc()){
      $PaperPrice[$PaperPriceDB['Name']] = $PaperPriceDB['Price']  ;
    } // LOOP 

    // this block is used to find the user grade limit 

    $GradeLimitData = 0 ; 
    $GradeLimit = $Controller->QueryData("SELECT grade_limit FROM set_grade WHERE employeet_id = ?" , [$_SESSION['EId']]  );
    $GradeLimitDatabase = $GradeLimit->fetch_assoc();
    if(empty($GradeLimitDatabase))   $GradeLimitData = 40  ;
    else $GradeLimitData  =  $GradeLimitDatabase['grade_limit']; 

    
 ?>

 <style>
/* // X-Large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) {  
  .form-check {
    font-szie:0.5rem!important; 
    font-weigth:bold; 
  }  
 }

/* // XX-Large devices (larger desktops, 1400px and up) */
@media (min-width: 1400px) { 
  .form-check {
    font-size:1rem;
    font-weigth:bold; 
  }  
 }
 

  .custom-search {
  position: relative;
  }


  .custom-search-input {
    width: 100%;
    padding: 10px 80px 10px 10px; 
    line-height: 1;
    box-sizing: border-box;
    outline: none;
  }
  .custom-search-botton {
    position: absolute;
    right: 5px; 
    top: 5px;
    bottom: 5px;
    border: 0;
    outline: none;
    z-index: 2;
  }

  .quotation-icon:active {
    padding:2px;
  }
  .quotation-icon:hover {
    color:#444444;
  }

  .form-control {
    border: 2px solid #000; 

  }
  .form-select {
    border: 2px solid #000; 
  }
  .form-check-input {
    border: 2px solid #000; 
  }

  .form-control:focus{
    box-shadow: 5px 10px #AAAAAA ;
  }

  .btn {
    border: 2px solid #0d6efd;

    
  }
  .bi-clipboard2-plus:active {
    padding:2px;
    
  }
  .bi-clipboard2-plus:hover{
    color:#0d6efd; 
  } 
  
 </style>

 <div class="card m-3  ">
    <div class="card-body    my-1   d-flex justify-content-between">
    
      <div>
        <h4>
          <svg onclick = "HideJobType();" title = "Click to Select Quotation Type"  xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-clipboard2-plus" viewBox="0 0 16 16">
            <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"></path>
            <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"></path>
            <path d="M8.5 6.5a.5.5 0 0 0-1 0V8H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V9H10a.5.5 0 0 0 0-1H8.5V6.5Z"></path>
          </svg>
          PKG Estimation Calculation Form For <span class = "" style= "color:#FA8b09;" >   <?php echo  "( ".  $Customer['CustName'] . " )"; ?> </span>   
        </h4>
      </div>

      <div class ="my-1" >

        <a class="btn btn-outline-primary mx-2 fw-bold " data-bs-toggle="collapse" href="#setting" role="button" aria-expanded="false" aria-controls="setting">  
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg> 
          More  
        </a>
        
        <a href="Manual/CustomerRegistrationForm_Manual.php" class = "text-primary" title = "Click to Read the User Guide " >
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>
        </a>
      </div>
                                       
    </div>
  </div>

<div class="collapse" id="setting">
  <div class="card card-body m-3">
    
      <!-- BUTTONS OUTSIDE OF FORM -->
      <div class="btn-group" role="group" aria-label="Top Buttons for Quotations">
           
            <a href="Customerlist2.php" title="Find and select customer"  class="btn btn-outline-primary  fw-bold" >
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>  
                Find Customer
            </a>


            <a href="javascript:poptastic('PolySearch.php');"  title="Find Exist Polymer & Die"  class="btn btn-outline-primary  fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                </svg>
                Find Polymer
            </a>
            <a href="javascript:poptastic('DieSearch.php');"  title="Record New Polymer & Die" class="btn btn-outline-primary  fw-bold" >
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                Search Die
            </a>
            <a  href="javascript:poptastic('../PaperStock/BalanceSheetPaper.php');"title="Find Paper In Stock "   class="btn btn-outline-primary  fw-bold" >
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
                    <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"/>
                </svg>
                Check Stock
            </a>
            <a title="Find and paper weight"  onclick="" class="btn btn-outline-primary  fw-bold" >
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">
                <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>
              </svg>
                Paper Weight
            </a>
      </div>
      <!-- BUTTONS OUTSIDE OF FORM -->
  </div>
</div>



<!-- CARD -->
<div class="card m-3 shadow">
  <div class="card-body"><!-- CARD-BODY -->

  <form class=" " enctype="multipart/form-data" id="feedback_form" method="post" action="<?=htmlspecialchars('QuotationController.php'); ?>">

      <?php $PaperGEP =  $Controller->QueryData("SELECT Id, PaperGSM, ExchangeRate, PolimerPrice FROM paperprice" , [] ); $GEP = $PaperGEP->fetch_assoc();   ?>
      <input type="hidden" name="CustomerId" value = "<?=$CustId?>" >
      <input type="hidden" name="EmployeeId" value = "<?=$_SESSION['EId']?>" >
      <input type="hidden" name="CTNPaper" id = "CTNPaper"  value = "" >
      <input type='hidden' name='ExchangeRate'  id='ExchangeRate' value = "<?=$GEP['ExchangeRate']?>" >
      <input type='hidden' name='PaperGSM'      id='PaperGSM'     value = "<?=$GEP['PaperGSM']?>" >
      <input type='hidden' name='PolimerPrice'  id='PolimerPrice' value = "<?=$GEP['PolimerPrice']?>" > 
 
      

      <div class="row my-3 gy-2 gx-3 align-items-center " id = "JobTypeRow"  style = "display:none;">
        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12   ">
        </div>
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <!-- ZERO ROW  -->
            <select name="jobType"  class ="form-select "    required >
              <option value="" >Quotation Type</option>
              <option value="Normal">New Quote</option>
              <option value="OnlyProduct">Stand Alone Product</option>
            </select>
            <!-- ZERO ROW  -->
        </div>
      </div>
        
      <hr id = "jobTypeHr" style = "display:none; ">
  
      <!-- FIRST ROW  -->
      <div class="row   align-items-center " >
        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12   ">
          <strong class = "fs-5 ms-5" > 
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          </svg>
          Customer Details </strong>
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"   >
        <label for="CustomerName" class="form-label">Last Job No <span class="text-danger"> * </span></label>
          <div class="custom-search" >
            <input type="text" class="custom-search-input form-control" value = "<?=$LastJobNo[3];?>" id="CustomerName"  name="CustomerName1" readonly >
              <a class="custom-search-botton text-dark"    onclick = "CopyValueToJobNo(<?=$LastJobNo[3];?>)"  > 
                <svg  class = "quotation-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                  <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                </svg>
              </a>  
          </div>
        </div>


        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="JobNo" class="form-label">Job No <span class="text-danger"> * </span> </label>
          <input class="form-control"  id="JobNo" name="JobNo" value="NULL" type="text"  placeholder="NULL" readonly  />
        </div>

        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="ProductName" class="form-label"> Product Name <span class="text-danger"> * </span>  </label>
          <input class="form-control" id="ProductName" placeholder="Write Product Name "  name="ProductName"   type="text" required  />
        </div>

        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="FinishDate" class="form-label">DeadLine <span class="text-danger " > * </span></label>
          <input type="Date" class="form-control" id="FinishDate" name="FinishDate" type="text" required  />
        </div>

        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="PaperGrade" class="form-label">Grade <span class="text-danger"> * </span></label>
          <input   class="form-control" id="PaperGrade"  name="PaperGrade" type="text" required onchange = 'AddInputValues(this.name , this.value)'   /> 
        </div>
      </div>
      <!-- FIRST ROW  -->

      <hr>
      <!-- SECOND ROW  -->
      <div class="row   align-items-center " >
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12  ">
          <strong  class = "fs-5 ms-5" >
          <svg    style = "transform: rotate(-180deg);"  xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16">
          <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z"/>
        </svg> Size Details </strong>

        </div>
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
            <label for="CartonUnit" class="form-label">Carton Type  <!-- AKA UNIT IN PREVIOUS FORM --> <span class="text-danger"> * </span></label>
            <select class="form-select" id="CartonUnit"  name="CartonUnit" onchange = "HideDie(this.value);"  >
              <option disabled = "disabled"  > Select Unit</option>
              <option value="Carton">Carton</option>
              <option value="Box">Box</option>
              <option value="Sheet">Sheet</option>
              <option value="Tray">Tray</option>
              <option value="Separator">Separator</option>
              <option value="Belt">Belt</option>
            </select>
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
          <label for="CartonQTY" class="form-label"> Quantity <span class="text-danger"> * </span> </label>
          <input class="form-control" id="CartonQTY" placeholder="Quantity" name="CartonQTY" type="text" required  onchange = "AddInputValues(this.name , this.value);"  />
        </div>

        <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
          <label for="PaperLength" class="form-label" > L <span class="text-danger"> * </span></label>
           <input class="form-control" id="PaperLength" placeholder="Lenght mm" name="PaperLength" type="text" onchange = "AddInputValues(this.name , this.value) "  required  />
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"  id = "PaperWidthCol">
          <label for="PaperWidth" class="form-label"> W <span class="text-danger"> * </span></label>
          <input class="form-control" id="PaperWidth" placeholder="Width mm" name="PaperWidth" type="text" onchange = "AddInputValues(this.name , this.value) "   value=""  />
        </div>

        <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
          <label for="PaperHeight" class="form-label"> H <span class="text-danger"> * </span></label>
          <input class="form-control"   id="PaperHeight"  placeholder="Height mm" name="PaperHeight"  onchange = "AddInputValues(this.name , this.value) "  type="text" required  />
        </div>
      </div>
      <!-- SECOND  ROW  -->
      <hr>


       <!-- THIRD ROW  -->
       <div class="row align-items-center "    >
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12   ">
          <strong  class = "fs-5 ms-5 "> 
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
          </svg> Paper Details </strong>
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <label for="CartonType" class="form-label">Carton Type <span class="text-danger"> * </span></label>
            <select class="form-select" onchange="ShowPly(this.value)" name="CartonType" id="CartonType" >
              <option> Select Ply Type</option>
              <option value="3">3-Ply</option>
              <option value="5">5-Ply</option>
              <option value="7">7-Ply</option>
            </select>
        </div>

        <!--   PaperLayerName with it is GSM  -->
          <?php for ($index=1; $index <= 7 ; $index++):   ?>
            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-3">
                  <select class="form-select " name="PaperLayerPrice_<?=$index?>" id="PaperLayerPrice_<?=$index?>" style="display: none;"   onchange = "ChangePrice( this.name , this.value ) "    >
                    <?php
                        foreach ($PaperPrice as $key => $value)   echo "<option value='$value'>L$index-$key</option>";
                    ?>
                  </select>
                  <input class="form-control mt-2"  style="display:none;" name="PaperLayerGSM_<?=$index?>" id="PaperLayerGSM_<?=$index?>" value="125" type="text" 
                   onchange = "ChangeGSM( 'PaperLayerPrice_<?=$index?>', this.value )"    />
            </div>
            <input type="hidden" name="PaperName_<?=$index?>" id = "PaperName_<?=$index?>" value = "" >
          <?php endfor; ?>
        <!--   PaperLayerName with it is GSM  -->
        
      </div>  <!-- THIRD  ROW  -->
      <hr>
      <!-- Fourth ROW  -->
      <div class="row   d-flex align-items-center  "  >
          <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12    " >
            <strong class = "fs-5 ms-5" >
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
              <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
              <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg> Print Details </strong>
          </div>
          <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label for="Flute" class="form-label">Flute Type   <span class="text-danger"> * </span></label>
              <select name="Flute" id = "FlutType"  class="form-select" required>
                <option value="">Flute Type</option>
              </select>
          </div>
   
          <!--   PaperLayerName with it is GSM  -->
          <?php  
         $CheckBoxs = [ 
          'CSlotted' => 'SLOTTED' ,
          'CDieCut' => 'DIE CUT' , 
          'CPasting' => 'PASTING' ,
          'CStitching' => 'STITCHING' ,
          'flexop' =>  'FLEXO P' , 
          'offesetp' => 'OFFSET P'];  

         foreach ($CheckBoxs as $key => $value):  ?>
            <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-3">
              <label for=" " class="form-label"> </label>
              <div class="form-check fw-bold" >
                <input class="form-check-input" type="checkbox" id="<?=$key?>" name="<?=$key?>" value = "Yes"> 
                <label class="form-check-label"   for="<?=$key?>"><?=$value?></label> 
              </div>
            </div>
        <?php endforeach; ?>
        <!--   PaperLayerName with it is GSM  -->
         
        </div>
        <!-- Fourth  ROW  -->
        <hr>

        <!-- FIFTH ROW  -->
        <div class="row  d-flex align-items-center  "  >
          <div class="col-xxl-2 col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
            <strong class = "fs-5 ms-5 "  > 
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-aspect-ratio" viewBox="0 0 16 16">
              <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
              <path d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
            </svg>
            P/D Details </strong>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="NoColor1" class="form-label">Select Color<span class="text-danger"> * </span></label>
            <select class="form-select " name="NoColor1" id="NoColor1">
              <option value="0" >No Color</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="FullColor">FColor</option>
            </select>
          </div>


          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label for="NoColor" class="form-label">Select Polymer<span class="text-danger"> * </span></label>
              <select class="form-select" name="NoColor" id="NoColor" onchange="AddInputValues(this.name , this.value);" >
                <option value="0" >Polymer Exist</option>
                <option value="0" >No Print</option>
                <option value="0" >Personal Polymer</option>
                <option value="0" >Free Polymer </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12" id="DieExist">
              <label for="DieExist" class="form-label">Select Die<span class="text-danger"> * </span></label>
              <select class="form-select" name="DieExist"   >
                <option value="0">New Die</option>
                <option value="0" >Die Exist</option>
                <option value="00" >Personal Die</option>
                <option value="00" >Free Die </option>
                <option value="0"> No Die</option>
              </select>
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label for="PolymerPrice" class="form-label">Polymer Price  </label>
            <input class="form-control" id="PolymerPrice" name="PolymerPrice" type="text" required   />
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-3 col-md-3 col-sm-12 col-xs-12" id="DiePrice">
            <label for="DiePrice" class="form-label" >Die Price  </label>
            <input class="form-control"  placeholder="Die Price" id = "DiePriceInput" name="DiePrice"  type="text" onchange = "AddInputValues(this.name , this.value)" value = ""  />
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <label   for="NoFlip"> </label>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox"  style = "transform: rotate(90deg);" id="NoFlip" name="NoFlip" onclick="ShowNoFlip();">
              <label class="form-check-label" for="NoFlip">Manual </label>
            </div>
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-4 col-md-4 col-sm-12 col-xs-12" style = "display:none; " id = "NoFilpArea"  >
              <label   for=""> </label>
              <div class="input-group">
                <input class="form-control" id="NoFlipLength" style = "max-width:50%"  placeholder="Length" value = ""    onchange = "AddInputValues(this.name , this.value , true  )"  type="text"  style="width:75px; " />
                <input class="form-control" id="NoFlipHeight"  style = "max-width:50%" placeholder="Height" value = ""    onchange = "AddInputValues(this.name , this.value , true  )"   type="text"  style="width:75px;" />
              </div>
          </div>

        </div>
        <!-- FIFTH  ROW  -->

        <hr>
        <!-- SIXTH ROW  -->
        <div class="row my-3   "  >
          <div class="col-xxl-2 col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center" >
            <strong class = "fs-5 ms-5 "  > 
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
              </svg>
              Cost Details </strong>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="PricePercarton" class="form-label">Currency <span class="text-danger"> * </span></label>
                <select class="form-select" name="CtnCurrency1" id="CtnCurrency1" required onchange = "ChangeCurrencyType( this.value)" >
                  <option value="" disabled>Select Currency</option>
                  <option value="AFN">AFN</option>
                  <option value="USD">USD</option>
                </select>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="TotalPriceAfn" class="form-label">Unit Price  <span id = "UPCurrencyLabel"></span> <span class="text-danger"> * </span></label>
                <input class="form-control" id="PaperPriceAFN" style="font-weight: bold;"   name="PaperPriceAFN"  type="text" required onchange = "ChangeGrade(this.value)"  />
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="TotalPrice" class="form-label">Sub Total   <span id = "TACurrencyLabel"></span>  <span class="text-danger"> * </span></label>
                <input class="form-control" id="TotalPrice" readonly  name="TotalPrice" type="text"  style="font-weight:bold;" /> 
          </div>
 
          <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="FinalTotal" class="form-label">Total Amount   <span id = "FTCurrencyLabel"></span>  <span class="text-danger"> * </span></label>
                <input class="form-control" id="FinalTotal" readonly  name="FinalTotal" type="text"  style="font-weight:bold;" /> 
          </div>
          

          <div class="col-xxl-1 col-xl-1 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="Tax " class="form-label">Tax <span class="text-danger"> % </span></label>
                <select class="form-select" id="Tax"  name="Tax"  onchange = "AddInputValues(this.name , this.value)  "  >
                  <option value="" disabled>Select Tax</option>
                  <option value="0">None</option>
                  <option value="2">2 %</option>
                  <option value="4">4 % </option>
                </select>
          </div>

               
      

          <div class="col-xxl-1 col-xl-1 col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label for="d" class="form-label"> </label>
              <div> <a  class="btn btn-outline-primary fw-bold mt-2 " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">  Save </a>  </div>
          </div>
          
      </div>
      <!-- SIXTH  ROW  -->
      <hr>
      <!-- SEVENTH ROW  -->
      <div class="row my-3 d-flex align-items-center  " >
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12  ">
          <strong class ="fs-5 ms-5" > 
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-bookmark" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>
          Add Note </strong>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="Note1" class="form-label">Note For Job Card</label>
            <textarea name="Note1"  style="height: 100px;  " class = "form-control" placeholder = "Note For Order Card " ></textarea> 
        </div>
        <div  class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="Notemarket" class="form-label">Note For Quotation</label>
            <textarea name="Notemarket"  style="height: 100px; " class = "form-control" placeholder = "Note For Quotation" ></textarea> 
        </div>
        
        <div class=" col-2"   >
        <div class="collapse" id="collapseExample">
          <div class="  d-grid gap-2   mx-auto ">
            <button type="submit"  id="SaveButton"  name="SaveButton" class="btn btn-outline-primary fw-bold " style = "max-width:180px;"    >Save & Print</button>
            <button type="submit"  id="SendToDesign"  name="SendToDesign" class="btn btn-outline-primary fw-bold   " style = "max-width:180px;"  >Send To Design</button>
            <button type="submit"  id="SaveOnly"  name="SaveOnly" class="btn btn-outline-primary fw-bold    " style = "max-width:180px;"   >Save</button>
          </div>
        </div>

        </div>

      </div>
      <!-- SEVENTH  ROW  -->

  </div><!-- CARD-BODY -->
</div><!-- CARD -->
</form>



 <script>
  
  let InputValues = {}; 
  var PaperType =  {} 
  var Paper  =  {} 
  var ExchangeTotalPrice = []; 
  var Results = {}; 
  var CTNPaper = {}; 
  var GradeLimit = <?=$GradeLimitData?> ; 
  let ExchangeRate = document.getElementById("ExchangeRate").value-0; ;
 
  console.log(ExchangeRate);
  let Unit = document.getElementById("PolimerPrice").value-0; 
  let DatabasePaperGSM  = document.getElementById("PaperGSM").value-0 
  

  function Precision(x) {
    return Number.parseFloat(x).toFixed(2);
  }



  function AddToPaper(name , gsm , Price) {
    PaperType['GSM'] = Precision(gsm) ; PaperType['Price'] = Precision(Price); 
    Paper[name] = Object.assign({}, PaperType);
  } 

  function RemoveFromPaper(name) {
    delete Paper[name];  
  } 

  function ChangeGSM( name ,  value ) {
    Paper[name]['GSM'] = Precision(value);
    CalculateUnitPrice(InputValues);
  }

  function ChangePrice( name ,  value ) {
    Paper[name].Price = Precision(value);  
    CalculateUnitPrice(InputValues);
    StorePaperTypeName(name);


    // THis Block will change Paper GSM to 250 when we select BB else 125 
    let element = document.getElementById(name); 
    let PaperTypeName = element.options[element.selectedIndex].text.slice(3).trim();
    if(PaperTypeName == 'BB')  {
      document.getElementById('PaperLayerGSM_'+ name.slice(-1)).value = 250;
      document.getElementById('offesetp').checked = true;  
      ChangeGSM('PaperLayerPrice_'+ name.slice(-1),250); 
    }  
    else  {
      document.getElementById('PaperLayerGSM_'+ name.slice(-1)).value = 125 ; 
      document.getElementById('offesetp').checked = false;  
      ChangeGSM('PaperLayerPrice_'+ name.slice(-1),125); 
    }
  }

  function AddInputValues( name , value , NoFlip = false   ){
    
    value = Precision(value)

    if(name == 'PaperHeight')  document.getElementById('NoFlipHeight').value = value;  
    else if (name == 'PaperLength') document.getElementById('NoFlipLength').value = value;  


    if(name == 'PaperGrade') {
      if(value < 1 || value > 100 ) {
        alert('Grade must be within 1 and 100 : your value is ' + value ); 
        document.getElementById('PaperGrade').value = GradeLimit; 
        value = GradeLimit; 
      }
      else {
        if(value < GradeLimit ){
          alert('You are not allowed to set grade lower than ' + GradeLimit ); 
          document.getElementById('PaperGrade').value = GradeLimit; 
          value = GradeLimit; 
        }
      }
      
    }

    InputValues[name] = value; 
    CalculateUnitPrice(InputValues , NoFlip );  
 
  }
   
  function StorePaperTypeName(PaperLayerName ){
    let string = '' ;
    let element = document.getElementById(PaperLayerName); 
    CTNPaper[PaperLayerName] = element.options[element.selectedIndex].text.slice(3);  
    for (const key in CTNPaper) {
      string = string  +   CTNPaper[key] + " " ;   
    }
    document.getElementById('CTNPaper').value = string ; 
    document.getElementById('PaperName_'+ PaperLayerName.slice(-1)).value = element.options[element.selectedIndex].text.slice(3); 
  }






  // this function will show number of plys when we select 3-ply | 5-ply | 7-ply 
  function ShowPly(CT_Value){
        let display = null; 
        let CTNPaper = '' ;

        for (let index = 1; index <= 7   ;   index++) {
          if(index  <= CT_Value  ) {
            display = '';

            AddToPaper(  document.getElementById('PaperLayerPrice_'+ index).name  ,  
            document.getElementById('PaperLayerGSM_'+ index).value   , 
            document.getElementById('PaperLayerPrice_'+ index).value ); 

            let element = document.getElementById('PaperLayerPrice_'+ index); 
            AddToPaper(   element.name , document.getElementById('PaperLayerGSM_'+ index).value, element.value ); 
            CTNPaper = CTNPaper + ' ' +  element.options[element.selectedIndex].text.slice(3) ; 
            document.getElementById('PaperName_'+ index).value = element.options[element.selectedIndex].text.slice(3); 

          }  else  {display ='none'; RemoveFromPaper(document.getElementById('PaperLayerPrice_'+ index).name ); }
          document.getElementById('PaperLayerPrice_'+ index).style.display = display;
          document.getElementById('PaperLayerGSM_' + index).style.display = display;
        }

        let FlutOptions = ''; 
        if(CT_Value == 3 )  FlutOptions =  ' <option value="C">C</option> <option value="B">B</option> <option value="E">E</option> ';  
        else if(CT_Value == 5 )  FlutOptions =  '  <option value="BC">BC</option> <option value="CE">CE</option> '; 
        else if(CT_Value == 7 )   FlutOptions =  '<option value="BCB">BCB</option>'; 
        else FlutOptions = '<option value="C">C</option><option value="B">B</option><option value="E">E</option><option value="BC">BC</option><option value="CE">CE</option><option value="BCB">BCB</option>'; 

        document.getElementById('FlutType').innerHTML = FlutOptions ; 
        document.getElementById('CTNPaper').value = CTNPaper ; 
        CalculateUnitPrice(InputValues); 

  } // END OF SLOWPLY 
 

 
  function CalculateUnitPrice(InputValues , NoFlip = false){

    let BoxQuantity = Number(InputValues['CartonQTY'] ) || 0 ;
    let Grade = Number(InputValues['PaperGrade']) || 0;
    let UserLength = Number(InputValues['PaperLength'])  || 0;
    let UserWidth =  Number(InputValues['PaperWidth']) || 0;
    let UserHeight =  Number(InputValues['PaperHeight']) || 0;
    let DiePrice = Number(InputValues['DiePrice']) || 0;
    let ColorNumber = Number(InputValues['NoColor']) || 0;
    let Tax = Number(InputValues['Tax']) || 0;
    var Length , Height ; 
    let Values = {}; 

    Length = (2 * UserLength) + ( 2 * UserWidth) + 50;  
    if(NoFlip) {
        // WITH NO FLIP 
        Height = UserHeight ;  
    }
    else {
        //  WITH FLIP  
        Height = UserWidth + UserHeight;
    }

    // To Find POLYMER : Polymer size in mm 2 
    let PolymerSize = (Length * Height) / 100 ;
    let TotalPolymerSize = PolymerSize * ColorNumber ; 
    let PolymerPrice = TotalPolymerSize * Unit; 



   
    // this block is used to calculate and sum each ply or paper price 
    var PaperTotalPrice = 0 ; 
    ExecuteOnlyOnce = true; 
    let DeductedPaperPrice = 0 ; 
   

    let indexxx = 1 ; 
    for (const property in Paper) {    
        let EachPaperPrice = Number(CalculateEachPaperPrice(Length , Height , Paper[property].GSM  , Paper[property].Price  ));
        // PaperTotalPrice  =  PaperTotalPrice +  EachPaperPrice; 
        let element = document.getElementById('PaperLayerPrice_'+ indexxx); // element.name , document.getElementById('PaperLayerGSM_'+ index).value, element.value    
        Values[element.options[element.selectedIndex].text.slice(3) + "_" + indexxx] =  EachPaperPrice;
        indexxx++;



 
    }


       
    let value_length = 0 ;
    if( Object.keys(Values).length == 3 ) value_length = 1 ; 
    if( Object.keys(Values).length == 5 ) value_length = 2 ; 
    if( Object.keys(Values).length == 7 ) value_length = 3; 

    // Values.hasOwnProperty('toString'); 


    let value_counter = 1 ; 
    for (const property in Values) {  
     
      if( value_counter <= value_length )  {
          if(property.includes("Flute")){
                PaperTotalPrice = PaperTotalPrice +  (Values[property] * 1.38 )  ;  
                value_counter++; 
          }
          else {
            PaperTotalPrice = PaperTotalPrice + Values[property];
          }
      }
      else {
          PaperTotalPrice = PaperTotalPrice + Values[property];
        }

    
      
     } // end of loop 

    //  console.log(  Values  ); 
   

    // console.log('-- ' +  PaperTotalPrice + ' --'  ) 
  //   PaperTotalPrice = Number(Precision(PaperTotalPrice)); 
  //  console.log('-- ' + PaperTotalPrice + ' --'  ) 


   

    // This line is used for reversing the formulla and to find grade 
    Results['UnitPrice'] = PaperTotalPrice; 
    let PaperGrade  = (( PaperTotalPrice * Grade ) / 100);
    // PaperGrade = Number(Precision(PaperGrade)); 





   

    // UNIT IS THE SUM OF all paper price + grade 
    let UnitPrice = PaperTotalPrice +  PaperGrade;


    // console.log('Paper Grade : ' + typeof PaperGrade + ' --'  ) 
    // console.log('PaperTotalPrice : ' + typeof  PaperTotalPrice + ' --'  ) 
    // console.log('' + UnitPrice + ' --'  ) 

    
    // change the price from USD to AFN 
    PolymerPrice = PolymerPrice * ExchangeRate ; 
    UnitPriceRate = UnitPrice * ExchangeRate ; 


    // console.log('' + UnitPriceRate + ' -- Final UNIT Price'  )
 
    let TotalPrice  = UnitPriceRate * BoxQuantity ; 


    
    
    let FinalPrice  = TotalPrice + PolymerPrice + DiePrice ; 

    // to add tax value if we have it. 
    TaxAmount = ( FinalPrice * Tax ) / 100 ; 
    FinalPrice = FinalPrice + TaxAmount; 

    document.getElementById('PolymerPrice').value   =  Math.round((PolymerPrice + Number.EPSILON) * 100) / 100;  
    document.getElementById('PaperPriceAFN').value  =   Precision(UnitPriceRate) 
    document.getElementById('TotalPrice').value     =     Precision(TotalPrice)  
    document.getElementById('FinalTotal').value     =  Math.round((FinalPrice + Number.EPSILON) * 100) / 100; 

    // STORE below results in array for exchange in afn and USD 
    ExchangeTotalPrice[0] = UnitPriceRate; 
    ExchangeTotalPrice[1] = TotalPrice;
    ExchangeTotalPrice[2] = PolymerPrice;
    ExchangeTotalPrice[3] = DiePrice;
    ExchangeTotalPrice[4] = FinalPrice;


    // this part is to emptying polymer price when there no color selected 
    let NoColor = document.getElementById('NoColor');
    let smile = NoColor.options[NoColor.selectedIndex].value
    if( smile == '0') {
      document.getElementById('PolymerPrice').value = 0;
    }  
    
       

    


    // console.log(InputValues); 
    // 
  } // END OF Calculate Unit Price 

  function CalculateEachPaperPrice( Length , Height , PaperGSM ,  Price  ){
    let PaperGsm1 = ( Length * Height * PaperGSM ) / 1000000;
    let Wastage = (  PaperGsm1 * 10  / 100  )  + PaperGsm1; 
    let PaperPrice = ( Price / 1000000 ) * Wastage ; //* DatabasePaperGSM;  // THERE IS ANOTHER CHAGNE WHICH IS  ( Price / 1000000 ) * Wastage * PaperGSM from table  which is DatabasePaperGSM 
    return PaperPrice ; 
  } // CALCULATE EACH PAPER PRICE 


  //     Wastage = Precision(Wastage) ;  PaperPrice = Precision(PaperPrice) ;    PaperGsm1 = Precision(PaperGsm1) ; 
  function ChangeCurrencyType( value ) {
    let UnitPrice =  ExchangeTotalPrice[0];
    let TotalPrice = ExchangeTotalPrice[1];
    let PolymerPrice = ExchangeTotalPrice[2];
    let DiePrice = ExchangeTotalPrice[3];
    let FinalPrice = ExchangeTotalPrice[4];
    // If the checkbox is checked, display USD total price and total  
    if (value == 'USD'){
      document.getElementById('PaperPriceAFN').value =    ExchangeTotalPrice[0]  / ExchangeRate ; 
      document.getElementById('TotalPrice').value =       Math.round((ExchangeTotalPrice[1] / ExchangeRate  + Number.EPSILON) * 100) / 100; 
      document.getElementById('PolymerPrice').value =     Math.round((ExchangeTotalPrice[2] / ExchangeRate  + Number.EPSILON) * 100) / 100; 
      document.getElementById('DiePriceInput').value =    Math.round((ExchangeTotalPrice[3] / ExchangeRate  + Number.EPSILON) * 100) / 100; 
      document.getElementById('FinalTotal').value =       Math.round((ExchangeTotalPrice[4] / ExchangeRate  + Number.EPSILON) * 100) / 100;  

      document.getElementById('UPCurrencyLabel').innerText = 'USD';
      document.getElementById('TACurrencyLabel').innerText = 'USD';
      document.getElementById('FTCurrencyLabel').innerText = 'USD';
    } else if(value == 'AFN')  {
        document.getElementById('PaperPriceAFN').value =  UnitPrice; 
        document.getElementById('TotalPrice').value = Math.round(( TotalPrice + Number.EPSILON) * 100) / 100  ;
        document.getElementById('PolymerPrice').value = Math.round(( PolymerPrice + Number.EPSILON) * 100) / 100  ;
        document.getElementById('DiePriceInput').value = Math.round(( DiePrice + Number.EPSILON) * 100) / 100  ;
        document.getElementById('FinalTotal').value =       Math.round(( FinalPrice + Number.EPSILON) * 100) / 100;  

        document.getElementById('UPCurrencyLabel').innerText = 'AFN';
        document.getElementById('TACurrencyLabel').innerText = 'AFN';
        document.getElementById('FTCurrencyLabel').innerText = 'AFN';
    } // END OF ELSE IF BLOCK   
  } // END OF cHANGE CURRENCY TYPE 

  function ShowNoFlip(){
    let UserLength = Number(InputValues['PaperLength'])  || 0;
    let UserWidth =  Number(InputValues['PaperWidth']) || 0;
    let UserHeight =  Number(InputValues['PaperHeight']) || 0;

    if(document.getElementById('NoFlip').checked == true )  {
        document.getElementById('NoFilpArea').style.display = '';
        CalculateUnitPrice(InputValues , true );
        document.getElementById('NoFlipLength').value  =  (2 * UserLength) + ( 2 * UserWidth) + 5
        document.getElementById('NoFlipHeight').value  =  UserHeight
    } else {
        document.getElementById('NoFilpArea').style.display = 'none'; 
        InputValues['PaperLength'] =   Number(document.getElementById('PaperLength').value  );
        InputValues['PaperHeight'] =   Number(document.getElementById('PaperHeight').value  ); 
        CalculateUnitPrice(InputValues );  
    } 

  } // SHOW NO FLIP 



  function ChangeGrade( UserUnitPrice){
    let UUP = UserUnitPrice / ExchangeRate ; 
    let Grade = (100 *  UUP -  100 * Results['UnitPrice']  ) ; 
    let Grade1 = Grade  /  Results['UnitPrice']; 
    document.getElementById('PaperGrade').value = Grade1; 
    AddInputValues('PaperGrade' , Grade1)
  } // CHANGE GRADE 

  // THIS FUNCTION IS CHECK EMPTYNESS OF FIELDS 
  function isEmpty(str) {
      return !str.trim().length;
  }

  function CopyValueToJobNo(value){
    let JobNumber = document.getElementById('JobNo') ; 
    if(isEmpty(JobNumber.value)) JobNumber.value = value + 1 ;
    else JobNumber.value = '' ;
  }
 
  function HideJobType(){
    let jobtype =  document.getElementById('JobTypeRow') ;
    if(jobtype.style.display == 'none') {
      jobtype.style.display = '';   document.getElementById('jobTypeHr').style.display = ''; 
    }
    else {
      jobtype.style.display = 'none';  document.getElementById('jobTypeHr').style.display = 'none'; 
    }

  }
   
  function HideDie(value){
    if(value == 'Carton') {
      document.getElementById('PaperWidthCol').style.display = '' ;
    }
    else {
      document.getElementById('PaperWidthCol').style.display = 'none' ;
    }
  }






  // PaperTotalPrice = 0.02927925 ; 
  // PaperTotalPrice = 3.8539421249999997

  //  PaperTotalPrice = Precision(PaperTotalPrice); 
  //  console.log('-- ' + PaperTotalPrice + ' --'  ) 


// 3.8209421249999997







 </script>
<?php  require_once '../App/partials/Footer.inc'; ?>