<?php 
 ob_start();
  require_once '../Assets/Zebra/Zebra_Pagination.php';
  $pagination = new Zebra_Pagination();
  require_once '../App/partials/header.inc';    

    $RECORD_PER_PAGE = 15;
    $DEFAULT_COLUMNS = 'CustId ,CustName , CusProvince , CustCatagory ,CusSpecification , CusStatus , AgencyName '; 
    $DEFAULT_TABLE_HEADING = "<th>#</th> <th>Cust Id</th> <th>Name</th> <th>Province</th> <th>Catagory</th> <th>Specification</th> <th>Status</th> <th>Agency Name</th>  <th> OPS</th>";
    $CUSTOMER_COUNT = ''; 

    if( isset($_SESSION['CL_DEFAULT_COLUMNS']) ){
      $DEFAULT_COLUMNS = $_SESSION['CL_DEFAULT_COLUMNS']  ; 
    }
    
    if(isset($_SESSION['CL_DEFAULT_TABLE_HEADING']) ){
      $DEFAULT_TABLE_HEADING = $_SESSION['CL_DEFAULT_TABLE_HEADING']; 
    }

    
    if(isset($_POST) && !empty($_POST)) {

      $SpecificationClause = ''; 
      $AgencyClause = ''; 
      $StatusClause = ''; 
      $Where = 'WHERE' ; 
      $And = '';
      $QueryParam = []; 
      $WhereClause = '';

      if(isset($_POST['Agency'])  && isset($_POST['Status'])  && isset($_POST['Specification'])  ) {
          $Status = $Controller->CleanInput($_POST['Status']);
          $Specification = $Controller->CleanInput($_POST['Specification']);
          $Agency = $Controller->CleanInput($_POST['Agency']);

          if( $Agency == 'ALL' && $Status == 'ALL' && $Specification == 'ALL'  ) {
            $WhereClause = ''; 
          }
          elseif( $Agency != 'ALL' && $Status == 'ALL' && $Specification == 'ALL'  ) {
            $WhereClause = ' WHERE AgencyName= ?   '; 
            $QueryParam  = [$Agency   ];
          }
          elseif( $Agency != 'ALL' && $Status != 'ALL' && $Specification == 'ALL'  ) {
            $WhereClause = ' WHERE AgencyName= ? AND CusStatus = ?  '; 
            $QueryParam  = [$Agency , $Status ];
          }
          elseif( $Agency != 'ALL' && $Status != 'ALL' && $Specification != 'ALL'  ) {
            $WhereClause = ' WHERE AgencyName= ? AND CusStatus = ? AND CusSpecification = ? '; 
            $QueryParam  = [$Agency , $Status , $Specification ];
          }
          elseif( $Agency == 'ALL' && $Status != 'ALL' && $Specification != 'ALL'  ) {
            $WhereClause = ' WHERE  CusStatus = ? AND CusSpecification = ? '; 
            $QueryParam  = [ $Status , $Specification ];
          }
          elseif( $Agency == 'ALL' && $Status == 'ALL' && $Specification != 'ALL'  ) {
            $WhereClause = 'WHERE CusSpecification = ?'; 
            $QueryParam  = [ $Specification ];
          }
          elseif( $Agency == 'ALL' && $Status != 'ALL' && $Specification == 'ALL'  ) {
            $WhereClause = 'WHERE  CusStatus = ? '; 
            $QueryParam  = [ $Status ];
          }
          
          $Query = "SELECT $DEFAULT_COLUMNS FROM  ppcustomer $WhereClause  ORDER BY CustId DESC " ;
          $PaginateQuery = "SELECT COUNT(CustId) AS RowCount FROM ppcustomer  $WhereClause  ORDER BY CustId DESC "; 
          $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
          $DataRows  = $Controller->QueryData( $Query, $QueryParam  );
          $RowCount =  $Controller->QueryData(   $PaginateQuery , $QueryParam  );
          $row = $RowCount->fetch_assoc(); 
          $pagination->records($row['RowCount']);
          $pagination->records_per_page($RECORD_PER_PAGE);

          $_SESSION['CUSTOMER_LIST_QUERY'] = [
            'Query' => $Query,
            'PaginationQuery' =>  $PaginateQuery ,
            'Param' => $QueryParam 
          ]; 

          $CUSTOMER_COUNT = $row['RowCount']; 

      } # END OF 3 SELECT BRANCH - STATUS - SPECIFICATION 
      else if(isset($_POST['Agency'])  || isset($_POST['Status'])  || isset($_POST['Specification']) ) {
        die('Incorrect Post Request!');
      }


      if (filter_has_var(INPUT_POST, 'FieldType')  && filter_has_var(INPUT_POST, 'SearchTerm') ) {
        if(!empty($_POST['FieldType']) &&  !empty($_POST['SearchTerm'])  ) {
          $FieldType = $Controller->CleanInput($_POST['FieldType']);
          $SearchTerm = $Controller->CleanInput($_POST['SearchTerm']);
          $DataRows = $Controller->Search("ppcustomer" , $FieldType , $SearchTerm , $DEFAULT_COLUMNS);
        }
      }
      else if( filter_has_var(INPUT_POST, 'FieldType')  || filter_has_var(INPUT_POST, 'SearchTerm') ) {
        die('Incorrect Post Request!');
      }

      if (filter_has_var(INPUT_POST, 'SetColumns') ) {
        $DEFAULT_COLUMNS = ''; 
        $DEFAULT_TABLE_HEADING = '';
        if(isset($_POST['Default'])) { 
          $DEFAULT_COLUMNS = $_POST['Default']  ; 
          $DEFAULT_TABLE_HEADING = "<th>Cust ID</th><th> Name</th> <th>Province</th> <th>Catagory</th> <th>Specification</th> <th>Status</th> <th>Agency Name</th> ";
        }
        else {
          foreach ($_POST as $key => $POST) {
              if ($POST === '200') {
                    if ($key === array_key_last($_POST)) {
                        $DEFAULT_COLUMNS .= $key ;
                        $DEFAULT_TABLE_HEADING .= "<th> $key </th>";
                    } else {
                        $DEFAULT_COLUMNS .= $key . ',';
                        $DEFAULT_TABLE_HEADING .= "<th> $key </th>";
                    }
              }
            } # END OF LOOP

            if(empty($DEFAULT_COLUMNS) && empty($DEFAULT_TABLE_HEADING) ) {
              $DEFAULT_COLUMNS = 'CustId,CustName , CusProvince , CustCatagory ,CusSpecification , CusStatus , AgencyName'; 
              $DEFAULT_TABLE_HEADING = "<th>Cust ID</th><th> Name</th> <th>Province</th> <th>Catagory</th> <th>Specification</th> <th>Status</th> <th>Agency Name</th>";
            }
        }
        
          // $DEFAULT_COLUMNS = 'CustName , CusProvince , CustCatagory ,CusSpecification , CusStatus , AgencyName , CustId'; 
          $DEFAULT_COLUMNS  .=  ',CustId'; 
          $_SESSION['CL_DEFAULT_COLUMNS'] = $DEFAULT_COLUMNS ;
          $_SESSION['CL_DEFAULT_TABLE_HEADING'] = '<th>#</th>' . $DEFAULT_TABLE_HEADING . '<th>OPS</th>';

          

          // echo $_SESSION['CL_DEFAULT_COLUMNS'];
          $Query = "SELECT $DEFAULT_COLUMNS FROM  ppcustomer ORDER BY CustId DESC " ;
          $PagQuery = ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
          $Query .=   $PagQuery;
          $DataRows  = $Controller->QueryData( $Query,[]);
 
          $RowCount =  $Controller->QueryData('SELECT COUNT(CustId) AS RowCount FROM ppcustomer  ORDER BY CustId DESC ' , [] );
          $row = $RowCount->fetch_assoc(); 
          $pagination->records($row['RowCount']);
          $pagination->records_per_page($RECORD_PER_PAGE);

          $_SESSION['CUSTOMER_LIST_QUERY'] = [
            'Query' => $Query ,
            'PaginationQuery' =>  'SELECT COUNT(CustId) AS RowCount FROM ppcustomer  ORDER BY CustId DESC' 
          ]; 

          $CUSTOMER_COUNT = $row['RowCount']; 
      }  
} # END OF ISSET POST IF BLOCK 
else {
  # DEFAULT CASE 
      if(isset($_SESSION['CUSTOMER_LIST_QUERY']['Query']) && !empty($_SESSION['CUSTOMER_LIST_QUERY']['Query']) && 
        isset($_SESSION['CUSTOMER_LIST_QUERY']['Param']) && !empty($_SESSION['CUSTOMER_LIST_QUERY']['Param'])){
        
        $Query = $_SESSION['CUSTOMER_LIST_QUERY']['Query']; 
        $DataRows  = $Controller->QueryData( $Query, $_SESSION['CUSTOMER_LIST_QUERY']['Param'] );
        $RowCount =  $Controller->QueryData( $_SESSION['CUSTOMER_LIST_QUERY']['PaginationQuery'] , $_SESSION['CUSTOMER_LIST_QUERY']['Param'] );
        $row = $RowCount->fetch_assoc(); 
        $pagination->records($row['RowCount']);
        $pagination->records_per_page($RECORD_PER_PAGE);
        
        $CUSTOMER_COUNT = $row['RowCount']; 
 
      }
    else {
      // var_dump($_SESSION);
      // echo $DEFAULT_COLUMNS = 'CustName , CusProvince , CustCatagory ,CusSpecification , CusStatus , AgencyName , CustId'; 
      $Query = "SELECT $DEFAULT_COLUMNS  FROM  ppcustomer ORDER BY CustId DESC" ;
      $PagQuery = ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
      $Query .=   $PagQuery;
      $DataRows  = $Controller->QueryData($Query, [] );
      $RowCount =  $Controller->QueryData('SELECT COUNT(CustId) AS RowCount FROM ppcustomer ORDER BY CustId DESC' , [] );
      $row = $RowCount->fetch_assoc(); 
      $pagination->records($row['RowCount']);
      $pagination->records_per_page($RECORD_PER_PAGE);
      $CUSTOMER_COUNT = $row['RowCount']; 

    }

} # END OF ISSET POST ELSE BLOCK
  require_once '../App/partials/Menu/MarketingMenu.inc';
  $Gate = require_once  $ROOT_DIR . '/Auth/Gates/CUSTOMER_LIST';



 
  // $_SESSION['USER_ACCESS_LIST'] = ['RNC' , 'VCP' , 'VCLSB'];
  // var_dump($_SESSION['ACCESS_LIST']);
  // echo "<br>";
  // var_dump($Gate); 
  
  
  if(!in_array( $Gate['VIEW_CUSTOMER_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
  }




  ob_end_flush();
?>
 
 

<?php 
    if (filter_has_var(INPUT_GET, 'message') ) {
      $message = $_GET['message'];
      $state = $_GET['success'];
      
      $className   = ($state == 1 ) ? 'alert-success' : 'alert-danger'; 
      $message =  explode(',' ,$message); 
      echo '<div class="alert  '  . $className  . '">'; 
      foreach ($message as $key => $Message) {
        echo <<<HEREDOC
            <li><strong>$Message </strong></li>
        HEREDOC;
      } 
      echo '</div>';
    }  
?>

 
<div class="card m-3 shadow">
      <div class="card-body d-flex justify-content-between  align-middle   ">
        
          <h3  class = "m-0 p-0  " > 
          <a class="btn btn-outline-primary btn-sm P-1 " href="index.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                  </svg>
              </a>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
              <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
              <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
            </svg>
            Customer List  <span style= "color:#FA8b09;" > <?php if(isset($_POST['Agency']))  echo " - ( " . $_POST['Agency'] . " Branch )"?> </span>     
          </h3>
          <div  class = "my-1"> <!--Button trigger modal div-->
                  <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
                  <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                  <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                  </svg>
                      </a>

              <?php  if(in_array( $Gate['REGISTER_NEW_CUSTOMER'] , $_SESSION['ACCESS_LIST']  )) { ?>
                  <a href=" CustomerRegistrationForm.php" class = "btn btn-outline-primary btn-sm  "  title = "Click to add customer" >  
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16" >
                      <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                  </svg> 
                  Add Customer 
                  </a>
              <?php } ?>

                  <!-- <a href = "CustomerListPrint.php" class="btn btn-outline-primary  my-1"  title = "Click to Print Customer List ">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                  </svg>
                  Print
                  </a> -->


                  <?php  if(in_array( $Gate['VIEW_CUSTOMER_LIST_ESTIMATE_PRICE_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                  <a class="   btn btn-outline-primary btn-sm   "     href="Quotation.php?CustId=1&CostEstimation=1"  title = "New Quotation">
                      <svg xmlns="http://www.w3.org/2000/svg" style = "font-weight:bold"  width="22" height="22" fill="currentColor" class="bi bi-clipboard2-plus" viewBox="0 0 16 16">
                      <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"/>
                      <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"/>
                      <path d="M8.5 6.5a.5.5 0 0 0-1 0V8H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V9H10a.5.5 0 0 0 0-1H8.5V6.5Z"/>
                      </svg>
                      Estimate Price
                  </a> 
                  <?php } ?>
                  <?php  if(in_array( $Gate['VIEW_CUSTOMER_LIST_SETUP_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                  <button type="button" class="btn btn-outline-primary btn-sm  " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Click to setup Columns  ">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                          <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                          <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                      </svg>
                      Setup
                  </button>
                  <?php } ?>
        </div><!-- Button trigger modal div end -->

      </div>
</div> 

 
      
<div class="card m-3" style = "font-family: Roboto,sans-serif;">
   <div class="card-body">
   

  <div class="row">
    
    <div class = "col-lg-2 col-md-6 col-sm-6 col-xs-12">
      <label for="name" class="fw-bold">Select Agency</label>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
          <select class="form-select my-1 " name="Agency" id = "Agency"   >
            <option disabled="disabled" >Select Catagory</option>      
            <option  selected  value="<?= (isset($_POST['Agency'])) ?  $_POST['Agency'] : 'ALL' ?>">   <?= (isset($_POST['Agency'])) ?  $_POST['Agency'] : 'ALL' ?>  </option>  
            <option value="ALL">ALL </option>
            <option value="Main Office">Main Office</option>
            <option value="Bagh Dawood">Bagh Dawood</option>
            <option value="Mazar">Mazar</option>
            <option value="Herat">Herat</option>
            <option value="Kandahar">Kandahar</option>
          </select>
    </div>

    <div class = "col-lg-2 col-md-6 col-sm-6 col-xs-12">
          <label for="name" class="fw-bold">Select Status </label>
            <select class="form-select  my-1 "    name="Status" id = "Status" >
              <option  disabled="disabled"  >Select Status</option>  
              <option  selected  value="<?= (isset($_POST['Status'])) ?  $_POST['Status'] : 'ALL' ?>">   <?= (isset($_POST['Status'])) ?  $_POST['Status'] : 'ALL' ?>  </option>
              <option value="ALL">ALL </option>
              <option value="Active">Active</option>
              <option value="InActive">In Active</option>
              <option value="Prospect">Prospect</option>
              <option value="Pending">Pending </option>
            </select>
    </div>
    <div class = "col-lg-2 col-md-6 col-sm-6 col-xs-12">
            <label for="name" class="fw-bold">Select Specification   </label>
            <select class="form-select  my-1 "  onchange = "this.form.submit()" name="Specification" id = "Specification"  >
              <option  disabled="disabled"  >Select Specification</option> 
              <option  selected  value="<?= (isset($_POST['Specification'])) ?  $_POST['Specification'] : 'ALL' ?>">   <?= (isset($_POST['Specification'])) ?  $_POST['Specification'] : 'ALL' ?>  </option>
              <option value="ALL">ALL </option>  
              <option value="VVIP">VVIP </option>
              <option value="VIP">VIP</option>
              <option value="Medium">Medium</option>
              <option value="Low">Low </option>
              <option value="Idle">Idle </option>
            </select>
        </form>
    </div>
    
    <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12  ">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
        <label for="name" class="fw-bold">Search According to Name and etc </label>
          <div class="input-group my-1  ">
            
                <select class="form-select d-block" name="FieldType"  style = "max-width: 30%;">
                    <option disabled >Select a Field </option>  
                    <option value="CustName "> Customer Name</option>
                    <option value="CustCatagory "> Catagory</option>
                    <option value="CusProvince "> Customer Province</option>
                    <option value="AgencyName "> Agency Name</option>
                    <option value="BusinessType "> Business Type </option>
                    <option value="BusinessNature ">Business Nature </option>
                </select>
                <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                <button type="submit" class="btn btn-outline-primary">Find</button>
          </div>
        </form>
    </div>
    </div>
    </div>
</div>
 

<style>
         
            .draggable {
                cursor: move;
                user-select: none;
            }
            .placeholder {
                background-color: #edf2f7;
                border: 2px dashed #cbd5e0;
            }
            .clone-list {
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;
                display: flex;
            }
            .clone-table {
                border-collapse: collapse;
                border: none;
            }
            .clone-table th, .clone-table td {
                border: 1px solid #ccc;
                border-left: none;
                border-top: none;
                padding: 0.5rem;
            }
            .dragging {
                background: #fff;
                border-left: 1px solid #ccc;
                border-top: 1px solid #ccc;
                z-index: 999;
            }
        </style>
 <div class="card m-3">
   <div class="card-body  table-responsive   ">
    <table class="table"  id = "table"  >
          <thead class="table-info">
            <tr>   <?php if (isset($_SESSION['CL_DEFAULT_TABLE_HEADING']))  echo $_SESSION['CL_DEFAULT_TABLE_HEADING']; else echo $DEFAULT_TABLE_HEADING ?>   </tr>
          </thead>
          <tbody>
            <?php 
              $i = 1; 
              
      if(!empty($DataRows->num_rows) && ($DataRows->num_rows > 0)){
        foreach ($DataRows as $RowsKey => $Rows) {
            echo "<tr>";
            echo " <td>$i</td> ";
            foreach ($Rows as $key => $value) :?>
                     
                      <td>    <?=$value ?> </td>
                  <?php endforeach;
            $i++; ?> 
                <td style = "padding:0px;" >
             
                  <?php  if(in_array( $Gate['VIEW_PROFILE_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                    <!-- PROFILE  -->
                    <a class="btn btn-outline-primary btn-sm m-1"   href="CustomerProfile.php?id=<?=$Rows['CustId'] ?>"  title = "View Customer Profile" > 
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>
                      Profile
                    </a>
                  <?php } ?>

                  <!-- <a class="   btn btn-outline-primary  my-1 "     href="Quotation.php?CustId=<?=$Rows['CustId'] ?>"  title = "New Quotation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-clipboard2-plus" viewBox="0 0 16 16">
                      <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"/>
                      <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"/>
                      <path d="M8.5 6.5a.5.5 0 0 0-1 0V8H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V9H10a.5.5 0 0 0 0-1H8.5V6.5Z"/>
                    </svg>
                    Quot
                  </a> -->
                  
                </td>
                <?php echo "</tr>";
        }
    }// end of while loop
 
          else { ?>
            <tr class = "fs-5 text-danger text-center "  >
              <td colspan = "8" >NO RECORD FOUND </td>
            </tr>

            <?php  
            }// ELSE BLOCK IF CONDITION 

          ?>

          
          </tbody>
        </table>

        <div class = "d-flex justify-content-between  mx-auto" >
    


        <div class = "  my-2 ms-2">
          Showing <span class = "fw-bold" ><?=$i-1?></span> of  <span class = "fw-bold" ><?= $CUSTOMER_COUNT; ?></span>
        </div>

      

        <?php // render the pagination links
                $pagination->render();
            ?>
        </div>


</div>
 </div>
 </div>

<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Customer Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
         

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
            <div class="modal-body">
              
            
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                
                <input type="hidden" name="SetColumns" value = "Okay">
                  
                  <h5>Company Details</h5>
                  <hr>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustName" >    Company  Name   </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "BusinessType" >  Business Type     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "BusinessNature" >  Business Nature     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusSpecification" >  Customer Specification     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustCatagory" >  Customer Catagory     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusStatus" >  Status     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "Timelimit" >  Time Limit     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "PPCondition" >  Condition     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusRegistrationDate" >    Registration Date     </label> </div>
                </div><!-- END OF COL  -->

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

                  <h5>Contact Details</h5>
                  <hr>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustWorkPhone" >    Work Phone     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustWebsite" >    Website     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustAddress" >    Address     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustEmail" >    Email     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CmpZone" >  Region     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusProvince" >    Province     </label> </div>
                </div><!-- END OF COL   -->

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                  <h5>Contact Person</h5>
                  <hr>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustContactPerson" >      Name  </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustMobile" >    Mobile     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CmpWhatsApp" >  WhatsApp     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CustPostion" > Postion     </label> </div>
                  
                </div><!-- END OF COL   -->


                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                  <h5>User Details</h5>
                  <hr>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusReference" >   Reference     </label> </div>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "AgencyName" >  Agency Name     </label> </div>
                  <!-- <div class="checkbox"><label> <input disable  type="checkbox" value="200" name = "  " >  Assigned To      </label> </div> -->
                </div><!-- END OF COL   -->

              </div><!-- END OF ROW  -->
              <hr>
              <div class="checkbox"><label> <input type="checkbox" value="CustId,CustName,CusProvince,CustCatagory,CusSpecification,CusStatus,AgencyName " name = "Default" >   Default Columns   </label> </div>
              <hr>
              <table class = "table "  id = "SetColumnTable">
              </table>

            </div><!-- END OF MODAL BODY  -->



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger " data-bs-dismiss="modal">Close</button>
        <button   class="btn btn-outline-secondary"  type="reset" >Clear</button>
        <button   class="btn btn-primary"  type="submit" >Set Columns</button>
      </div>

      </form>
    </div>
  </div>
</div>
 

 



<script>
            document.addEventListener('DOMContentLoaded', function () {
                const table = document.getElementById('table');

                let draggingEle;
                let draggingColumnIndex;
                let placeholder;
                let list;
                let isDraggingStarted = false;

                // The current position of mouse relative to the dragging element
                let x = 0;
                let y = 0;

                // Swap two nodes
                const swap = function (nodeA, nodeB) {
                    const parentA = nodeA.parentNode;
                    const siblingA = nodeA.nextSibling === nodeB ? nodeA : nodeA.nextSibling;

                    // Move `nodeA` to before the `nodeB`
                    nodeB.parentNode.insertBefore(nodeA, nodeB);

                    // Move `nodeB` to before the sibling of `nodeA`
                    parentA.insertBefore(nodeB, siblingA);
                };

                // Check if `nodeA` is on the left of `nodeB`
                const isOnLeft = function (nodeA, nodeB) {
                    // Get the bounding rectangle of nodes
                    const rectA = nodeA.getBoundingClientRect();
                    const rectB = nodeB.getBoundingClientRect();

                    return rectA.left + rectA.width / 2 < rectB.left + rectB.width / 2;
                };

                const cloneTable = function () {
                    const rect = table.getBoundingClientRect();

                    list = document.createElement('div');
                    list.classList.add('clone-list');
                    list.style.position = 'absolute';
                    list.style.left = `${rect.left}px`;
                    list.style.top = `${rect.top}px`;
                    table.parentNode.insertBefore(list, table);

                    // Hide the original table
                    table.style.visibility = 'hidden';

                    // Get all cells
                    const originalCells = [].slice.call(table.querySelectorAll('tbody td'));

                    const originalHeaderCells = [].slice.call(table.querySelectorAll('th'));
                    const numColumns = originalHeaderCells.length;

                    // Loop through the header cells
                    originalHeaderCells.forEach(function (headerCell, headerIndex) {
                        const width = parseInt(window.getComputedStyle(headerCell).width);

                        // Create a new table from given row
                        const item = document.createElement('div');
                        item.classList.add('draggable');

                        const newTable = document.createElement('table');
                        newTable.setAttribute('class', 'clone-table');
                        newTable.style.width = `${width}px`;

                        // Header
                        const th = headerCell.cloneNode(true);
                        let newRow = document.createElement('tr');
                        newRow.appendChild(th);
                        newTable.appendChild(newRow);

                        const cells = originalCells.filter(function (c, idx) {
                            return (idx - headerIndex) % numColumns === 0;
                        });
                        cells.forEach(function (cell) {
                            const newCell = cell.cloneNode(true);
                            newCell.style.width = `${width}px`;
                            newRow = document.createElement('tr');
                            newRow.appendChild(newCell);
                            newTable.appendChild(newRow);
                        });

                        item.appendChild(newTable);
                        list.appendChild(item);
                    });
                };

                const mouseDownHandler = function (e) {
                    draggingColumnIndex = [].slice.call(table.querySelectorAll('th')).indexOf(e.target);

                    // Determine the mouse position
                    x = e.clientX - e.target.offsetLeft;
                    y = e.clientY - e.target.offsetTop;

                    // Attach the listeners to `document`
                    document.addEventListener('mousemove', mouseMoveHandler);
                    document.addEventListener('mouseup', mouseUpHandler);
                };

                const mouseMoveHandler = function (e) {
                    if (!isDraggingStarted) {
                        isDraggingStarted = true;

                        cloneTable();

                        draggingEle = [].slice.call(list.children)[draggingColumnIndex];
                        draggingEle.classList.add('dragging');

                        // Let the placeholder take the height of dragging element
                        // So the next element won't move to the left or right
                        // to fill the dragging element space
                        placeholder = document.createElement('div');
                        placeholder.classList.add('placeholder');
                        draggingEle.parentNode.insertBefore(placeholder, draggingEle.nextSibling);
                        placeholder.style.width = `${draggingEle.offsetWidth}px`;
                    }

                    // Set position for dragging element
                    draggingEle.style.position = 'absolute';
                    draggingEle.style.top = `${draggingEle.offsetTop + e.clientY - y}px`;
                    draggingEle.style.left = `${draggingEle.offsetLeft + e.clientX - x}px`;

                    // Reassign the position of mouse
                    x = e.clientX;
                    y = e.clientY;

                    // The current order
                    // prevEle
                    // draggingEle
                    // placeholder
                    // nextEle
                    const prevEle = draggingEle.previousElementSibling;
                    const nextEle = placeholder.nextElementSibling;

                    // // The dragging element is above the previous element
                    // // User moves the dragging element to the left
                    if (prevEle && isOnLeft(draggingEle, prevEle)) {
                        // The current order    -> The new order
                        // prevEle              -> placeholder
                        // draggingEle          -> draggingEle
                        // placeholder          -> prevEle
                        swap(placeholder, draggingEle);
                        swap(placeholder, prevEle);
                        return;
                    }

                    // The dragging element is below the next element
                    // User moves the dragging element to the bottom
                    if (nextEle && isOnLeft(nextEle, draggingEle)) {
                        // The current order    -> The new order
                        // draggingEle          -> nextEle
                        // placeholder          -> placeholder
                        // nextEle              -> draggingEle
                        swap(nextEle, placeholder);
                        swap(nextEle, draggingEle);
                    }
                };

                const mouseUpHandler = function () {
                    // // Remove the placeholder
                    placeholder && placeholder.parentNode.removeChild(placeholder);

                    draggingEle.classList.remove('dragging');
                    draggingEle.style.removeProperty('top');
                    draggingEle.style.removeProperty('left');
                    draggingEle.style.removeProperty('position');

                    // Get the end index
                    const endColumnIndex = [].slice.call(list.children).indexOf(draggingEle);

                    isDraggingStarted = false;

                    // Remove the `list` element
                    list.parentNode.removeChild(list);

                    // Move the dragged column to `endColumnIndex`
                    table.querySelectorAll('tr').forEach(function (row) {
                        const cells = [].slice.call(row.querySelectorAll('th, td'));
                        draggingColumnIndex > endColumnIndex
                            ? cells[endColumnIndex].parentNode.insertBefore(
                                  cells[draggingColumnIndex],
                                  cells[endColumnIndex]
                              )
                            : cells[endColumnIndex].parentNode.insertBefore(
                                  cells[draggingColumnIndex],
                                  cells[endColumnIndex].nextSibling
                              );
                    });

                    // Bring back the table
                    table.style.removeProperty('visibility');

                    // Remove the handlers of `mousemove` and `mouseup`
                    document.removeEventListener('mousemove', mouseMoveHandler);
                    document.removeEventListener('mouseup', mouseUpHandler);
                };

                table.querySelectorAll('th').forEach(function (headerCell) {
                    headerCell.classList.add('draggable');
                    headerCell.addEventListener('mousedown', mouseDownHandler);
                });
            });



            let SelectID = ['Agency' , 'Specification' , 'Status']


            for (let index = 0; index <  SelectID.length; index++) {
              var fruits = document.getElementById(SelectID[index]); 
              [].slice.call(fruits.options).map(function(a){  if(this[a.value]){    fruits.removeChild(a);  } else {   this[a.value]=1;  }  } , {});
            }


        </script>



<?php require_once 'partials/footer.inc'; ?>
