
<?php    

require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc';   
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 15;


    $DEFAULT_COLUMNS = 'CTNOrderDate , CTNId , JobNo  , CustName  , ProductName ,   CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,  CTNQTY  ,  CtnCurrency ,    CTNPrice  , CTNStatus  ,  CTNType '; 
    $DEFAULT_TABLE_HEADING = " <th>#</th> <th>Order Date </th> <th>Quot #</th> <th>Job #</th> <th>Company </th> <th>Product Description </th> <th>Size(LxWxH) cm </th>  <th>Order QTY</th>  <th class='text-end'>Unit Price</th> <th>Status</th>  ";
    // CTNId , JobNo  , CustName  , ProductName - CTNType  , CTNQTY  , 
    //CtnCurrency , CTNPrice, CTNStatus ,Edit  , CTNWidth ,CTNHeight, CTNLength  $DEFAULT_TABLE_HEADING  .= ' <th> OPS</th> ' ;
    $QueryDataArrayParam = [];  

if(isset($_POST) && !empty($_POST)) {
    
    if (filter_has_var(INPUT_POST, 'CustomerName') ) {
        $CustomerName = $Controller->CleanInput($_POST['CustomerName']);
        $CustomerName = trim($CustomerName);
        $DataRows  = $Controller->QueryData( "SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId = carton.CustId1 WHERE CustName = ? AND JobNo!='NULL' ", [$CustomerName] );
        $DEFAULT_TABLE_HEADING .= '<th> OPS</th>';
      }  

    if (filter_has_var(INPUT_POST, 'FieldType')  && filter_has_var(INPUT_POST, 'SearchTerm') ) {
      if(!empty($_POST['FieldType']) &&  !empty($_POST['SearchTerm'])  ) {
        $FieldType = $Controller->CleanInput($_POST['FieldType']);
        $SearchTerm = $Controller->CleanInput($_POST['SearchTerm']);
        $DEFAULT_COLUMNS1 =' CTNOrderDate , CTNId , JobNo , CustName  , ProductName ,   CONCAT( CTNWidth, " x ", CTNHeight , " x " , CTNLength ) AS Size ,  CTNQTY  ,  CtnCurrency ,    CTNPrice  , CTNStatus  ,  CTNType ';
        $DEFAULT_TABLE_HEADING = "<th>#</th><th>Order Date </th> <th>Quot #</th> <th>Job #</th> <th>Company Name </th>  <th>Product Description </th> <th>Size (mm) </th>  <th>Order QTY</th>  <th>Unit Price</th> <th>Status</th>  ";
        $EmployeetJoin = 'INNER JOIN ppcustomer ON carton.CustId1 = ppcustomer.CustId  ';  

        //     
        if( $_POST['FieldType'] === 'Ename'){
          $DEFAULT_COLUMNS1 .= ", Ename"; 
          $DEFAULT_TABLE_HEADING .= '<th> QuotedBy</th> <th> OPS</th>';
          $EmployeetJoin += "LEFT JOIN employeet ON employeet.EId = carton.EmpId "; 
        }
        else {
          $DEFAULT_TABLE_HEADING .= '  <th> OPS</th>';
        }
        $DataRows = $Controller->QueryData("SELECT $DEFAULT_COLUMNS1 FROM carton  $EmployeetJoin WHERE $FieldType  LIKE LOWER('%$SearchTerm%')", []);
      } # END FieldType SearchTerm 
    } # END SEARCH BLOCK 

    if (filter_has_var(INPUT_POST, 'ProductSetColumns') ) {
      $QueryWhereClause = ''; 
        if(isset($_POST['CustomerAgency']) && isset($_POST['CartonStatus']) ) {
            $CustomerAgencyWhere = ''; 
            $CartonStatusWhere = ''; 

            if( $_POST['CustomerAgency'] == 'ALL' && $_POST['CartonStatus'] == 'ALL' ) {
              $QueryWhereClause = ''; 
            }
            else if($_POST['CustomerAgency'] != 'ALL' &&  $_POST['CartonStatus'] == 'ALL' ) {
              $CustomerAgency = $_POST['CustomerAgency'];
              $QueryDataArrayParam = [ $CustomerAgency];
              $QueryWhereClause = "WHERE AgencyName = ?"; 
            }
            else if($_POST['CustomerAgency'] == 'ALL' &&  $_POST['CartonStatus'] != 'ALL' ) {
              $CartonStatus = $_POST['CartonStatus'];
              $QueryDataArrayParam = [ $CartonStatus];
              $QueryWhereClause = "WHERE CTNStatus = ? "; 
            }
            else if($_POST['CustomerAgency'] != 'ALL' &&  $_POST['CartonStatus'] != 'ALL' ) {
              $CustomerAgency = $_POST['CustomerAgency'];  $CartonStatus = $_POST['CartonStatus'];
              $QueryDataArrayParam = [$CustomerAgency , $CartonStatus];
              $QueryWhereClause = "WHERE AgencyName = ? && CTNStatus = ?";
              // $QueryWhereClause = "WHERE AgencyName = '$CustomerAgency' && CTNStatus = '$CartonStatus'";
            }
        }

        if(isset($_POST['Default'])) { 
          $Query  =  "SELECT $DEFAULT_COLUMNS  FROM  carton LEFT JOIN ppcustomer ON ppcustomer.CustId = carton.CustId1 $QueryWhereClause AND JobNo!='NULL' ";
          // $DEFAULT_TABLE_HEADING  .= ' <th> OPS</th> ' ; 
        }
        else {
            $EmployeetJoin = '';
            if(isset($_POST['Ename']) && !empty($_POST['Ename'])){
              $EmployeetJoin = "LEFT JOIN employeet ON employeet.EId = carton.EmpId "; 
            }

            if (in_array("200", $_POST)) $DEFAULT_COLUMNS .= ','; 
              foreach ($_POST as $key => $POST) {
                if ($POST === '200') {
                      if ($key === array_key_last($_POST)) {
                          $DEFAULT_COLUMNS .= $key ;
                          $DEFAULT_TABLE_HEADING .= "<th> $key </th>";
                      } 
                      else {
                          $DEFAULT_COLUMNS .= $key . ',';
                          $DEFAULT_TABLE_HEADING .= "<th> $key </th>";
                      }
                }
              } # END OF LOOP

              // $DEFAULT_TABLE_HEADING  .= '<th>OPS</th> ' ; 
              $Query  =  "SELECT $DEFAULT_COLUMNS  FROM  carton LEFT JOIN ppcustomer ON ppcustomer.CustId = carton.CustId1 $EmployeetJoin $QueryWhereClause AND JobNo!='NULL' ";
            } # END OF ELSE DEFAULT CASE \
                $DataRows  = $Controller->QueryData($Query, $QueryDataArrayParam);
        }  # END OF PRODUCT SET COLUMNS 


}
else
{
  // $DEFAULT_TABLE_HEADING  .= '<th>OPS</th> ' ;
  
  
  $Query = "SELECT $DEFAULT_COLUMNS  FROM  carton INNER JOIN ppcustomer ON ppcustomer.CustId = carton.CustId1 AND JobNo!='NULL'";
  $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
  
  $DataRows  = $Controller->QueryData( $Query, [] );
  
  $PaginateQuery = "SELECT COUNT(CTNId) AS RowCount  FROM  carton INNER JOIN ppcustomer ON ppcustomer.CustId = carton.CustId1  "; 


  $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
  $row = $RowCount->fetch_assoc(); 

  $pagination->records($row['RowCount']);
  $pagination->records_per_page($RECORD_PER_PAGE);
} # END OF ELSE DEFAULT CASE POST 

?>  


<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <a class="btn btn-outline-primary  btn-sm me-1" href="index.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a> 

            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"></path>
            </svg>
            Product List  <span>  <?php if(isset($_POST['CustomerAgency'])) echo " - " . $_POST['CustomerAgency'] . " Branch" ;   ?></span>
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <a href="Manual/ProductList_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
            </svg>
            </a>

            <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Setup Columns here ">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                </svg>
                Setup
            </button>
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 







<!-- <div class="m-3">
<div class="card mb-3 ">
  <div class="card-body d-flex justify-content-between" >
        <h5 class = "my-1 "> 
          

          <a class="btn btn-outline-primary  btn-sm me-1" href="index.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>

            

          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
          </svg>
          Product List  <span>  <?php if(isset($_POST['CustomerAgency'])) echo " - " . $_POST['CustomerAgency'] . " Branch" ;   ?></span>
        </h5>

        <div>
        <a href="Manual/ProductList_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>
        </a>

        <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Setup Columns here ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
            </svg>
            Setup
        </button>
        </div>
  </div>
</div> -->

<div class="card m-3 ">
  <div class="card-body    ">
                 
                <div class="row">
                  <div class = "col-lg-2 col-md-6 col-sm-6 col-xs-12">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
                         <input type="hidden" name="ProductSetColumns" value = "Okay">
                         <label for="name" class="fw-bold">Select Agency</label>
                        <select class="form-select my-1 " name="CustomerAgency"  >
                        <option disabled >Select Branch</option>       
                        <option value="ALL">ALL</option>
                        <option value="Main Office">Main Office</option>
                        <option value="Bagh Dawood">Bagh Dawood</option>
                        <option value="Mazar">Mazar</option>
                        <option value="Herat">Herat</option>
                        <option value="Kandahar">Kandahar</option>
                        </select>
                  </div><!-- END OF COL   -->
                  <div class = "col-lg-2 col-md-6 col-sm-6 col-xs-12">
                      <label for="name" class="fw-bold">Select Status </label>
                      <select class="form-select  my-1 "  name="CartonStatus" onchange = "this.form.submit()" >
                          <option disabled >Select Status</option>  
                          <option value="#"></option>
                          <option value="ALL">ALL</option>
                          <option value="Active">Active</option>
                          <option value="InActive">In Active</option>
                          <option value="Prospect">Prospect</option>
                          <option value="Pending">Pending </option>       
                          <option value="Completed">Completed</option>
                          <option value="New">New</option>
                          <option value="Cancel">Cancel</option>
                          <option value="Fconfirm">Fconfirm</option>
                          <option value="DesignProccess"> Design Proccess</option>
                          <option value="Production">Production</option>
                          <option value="Archieve">Archieve</option>
                      </select>
                    </form>
                  </div><!-- END OF COL   -->

                <div div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
                    <label for="name" class="fw-bold">Search Customer </label>
                    <input list="CLInputDataList"  class="form-control" onkeyup="AJAXSearch(this.value)"  placeholder="Search Customer Names here " name = "CustomerName" id="CLInput">
                    <datalist id="CLInputDataList">
                    </datalist>
                  </form>
                </div> <!-- END OF COL  -->

                <div class="col-lg-5 col-md-9  col-sm-12 col-xs-12 my-1 ">
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                      <label for="name" class="fw-bold">Search According to Name and etc ... </label>
                      <div class="input-group" >
                            <select class="form-select d-block " style = " max-width: 30%;"   name="FieldType"   >
                                <option disabled >Select a Field </option>
                                <option value="ProductName ">  Product Name  </option>
                                <option value="CTNId"> Quot Number</option>
                                <option value="JobNo"> Job Number </option>
                                <option value="CTNUnit"> Unit </option>
                                <option value="CTNStatus "> Status</option>
                                <option value="Ename"> QuotedBy</option>
                            </select>
                            <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                            <button type="submit" class="btn btn-outline-primary">Find</button>
                      </div>
                    </form>
                </div> <!-- END OF COL  -->
       
            </div> <!-- END OF ROW DIV INSIDE CARD-BODY  --> 
  </div><!-- END OF CARD-BODY  --> 
</div><!-- END OF CARD  -->

<div class="card m-3">
    <div class="card-body table-responsive    " >
    <table class="table "  id = "searchTab"  >
          <thead class="table-info">
            <tr>   <?php if (isset($DEFAULT_TABLE_HEADING))  echo  $DEFAULT_TABLE_HEADING ?>   </tr>
          </thead>
          <tbody>
            <?php
            $counter=1; 
            if (is_array($DataRows) || is_object($DataRows)) {
                foreach ($DataRows as $RowsKey => $Rows) {
                  echo "<tr style = 'padding-bottom:0px;'  >";
                  echo "<td>".$counter."</td>";
                    foreach ($Rows as $key => $value) :?>
                      <?php if($key == 'CTNType'){continue; } if($key == 'CtnCurrency') continue;   ?> 
                      <td <?php echo ($key  == 'CTNStatus') ?  ( ($value == "InActive") ? 'class = "bg-danger text-white fw-bold text-center align-middle"': ''  ) : ''; ?> style = "<?php if($key == "CTNPrice") echo "text-align:right;" ?> " >    
                          <?php 
                          if($key == 'ProductName') {
                              echo $value . ' - <span style = "color:#F86D09; font-size:12px;" >( ' . $Rows['CTNType'] . ' Ply )</span>';
                          }
                          elseif($key == 'CTNQTY')
                          {
                            echo  number_format( $value);
                          }
                          elseif($key == 'CTNPrice') 
                            {   
                                if($Rows['CtnCurrency']=='AFN')
                                {
                                    echo  number_format( $value, 2 ) .  " <span class='badge bg-warning'>".   $Rows['CtnCurrency'] ." </span>"; 
                                } 
                                elseif($Rows['CtnCurrency']=='USD')
                                {
                                    echo  number_format( $value, 3 ) .  " <span class='badge bg-warning'>".   $Rows['CtnCurrency'] ." </span>"; 
                                }
                                
                            }
                          else {
                            print $value; 
                          }
                           ?> 
                        
                        </td>
                    <?php endforeach;
                     ?> 
                <!-- <td>
                    EDIT   
                    <a class="text-primary m-1" href="QuotationEdit.php?Page=IndividualQuotation&CTNId=<?=$Rows['CTNId']; ?> " title="Edit">  
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                	<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                	<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>   -->
                <?php echo "</tr>";
                $counter++;
                }
            }// end of while loop
            else { ?>
            <tr class = "fs-5 text-danger text-center " colspan = "5"  >
              <td>NO RECORD FOUND </td>
            </tr>
            <?php    }// ELSE BLOCK IF CONDITION
             
            ?>
          </tbody>
        </table>
    </div><!-- END OF CARD-BODY  -->
</div><!-- END OF CARD  -->
</div><!-- END OF FIRST DIV  -->



<div class="card  ms-3 me-3 mb-3 p-0">
  <div class="card-body d-flex justify-content-center  ">
      <span class="pt-4"><?php $pagination->render(); ?></span>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Product Details </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
            <input type="hidden" name="ProductSetColumns" value = "Okay">
                            
            <div class="row">
                <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <select class="form-select my-1 " name="CustomerAgency"  >
                        <option disabled >Select Catagory</option>        
                        <option value="ALL">All</option>
                        <option value="Main Office">Main Office</option>
                        <option value="Bagh Dawood">Bagh Dawood</option>
                        <option value="Mazar">Mazar</option>
                        <option value="Herat">Herat</option>
                        <option value="Kandahar">Kandahar</option>
                        </select>
                </div><!-- END OF COL   -->
                <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <select class="form-select  my-1 "  name="CartonStatus" >
                            <option disabled >Select Status</option>  
                            <option value="ALL">All</option>
                            <option value="Active">Active</option>
                            <option value="InActive">In Active</option>
                            <option value="Prospect">Prospect</option>
                            <option value="Pending">Pending </option>       
                            <option value="Completed">Completed</option>
                            <option value="New">New</option>
                            <option value="Cancel">Cancel</option>
                            <option value="Fconfirm">Fconfirm</option>
                            <option value="DesignProccess"> Design Proccess</option>
                            <option value="Production">Production</option>
                            <option value="Archieve">Archieve</option>
                        </select>
                </div><!-- END OF COL   -->
            </div><!-- END OF ROW   -->
            <hr>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                  <label for="">Product Info</label>
                  <hr>
                  <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNColor" > Color </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusStatus" >  Status </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "JobType" > Order Type </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "ProductQTY" > Produced QTY </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNPaper" >    Used Paper    </label> </div>
                </div><!-- END OF COL   -->
                
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <label for="">Price Info</label>
                    <hr>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "GrdPrice" > Grade </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "PexchangeUSD"> Exchange Rate </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNUnit"  > Unit Price </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "CTNTotalPrice" > Gross Amount </label> </div>
                    <!-- <div class="checkbox"><label> <input type="checkbox" value="NetAmount" name = "NetAmount" disabled > Net Amount </label> </div> -->
                </div><!-- END OF COL  -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <label for="">Other </label>
                    <hr>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "CusProvince" > Province </label> </div>
                    <div class="checkbox"><label> <input type="checkbox" value="200" name = "Ename" >    Quoted By   </label> </div>
                </div><!-- END OF COL  -->
            </div><!-- END OF ROW  -->

            <hr>
            <div class="checkbox"><label> <input type="checkbox" value="Default" name = "Default" >   Default Columns   </label> </div>
        </div><!-- END OF MODAL BODY  -->
        <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button   class="btn btn-outline-primary btn-sm"  type="submit" >Set Columns</button>
        </div>

      </form>
    </div>
  </div>
</div>
 <!-- Modal -->


<script>
  function AJAXSearch(str) {
    if (str.length == 0) {
      return false;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200)  {
                var response = JSON.parse(this.responseText);
                var html = ''; 
                    if(response !=  '-1'){
                      for(var count = 0; count < response.length; count++) {
                                  html += '<option value="';
                                  html +=  response[count].CustName + '">'; 
                      }
                    }
                    else html += '<option value = "No Data Found" /> ';
                    document.getElementById('CLInputDataList').innerHTML = html;
          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
  }
</script>


<?php  require_once '../App/partials/Footer.inc'; ?>






