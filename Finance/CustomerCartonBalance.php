
<?php  
    require_once '../App/partials/Header.inc';  
    require_once '../App/partials/Menu/MarketingMenu.inc'; 
    require_once '../Assets/Zebra/Zebra_Pagination.php';
    $pagination = new Zebra_Pagination();
    $RECORD_PER_PAGE = 65;
    $Param = []; 


if((  isset($_POST['CustomerName']) && !empty('CustomerName') ) ) 
{

    $From = ''; $To  = ''; 
    if(isset($_POST['From']) && isset($_POST['To'])) 
    {
        $From= $Controller->CleanInput($_POST['From']);
        $To=$Controller->CleanInput($_POST['To']);
    }
 

    if($_POST['CustomerName'] == 'ALL') 
    {

        if (!empty($From) && !empty($To)) 
        {
            $Query="SELECT CTNId,  JobNo , ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
            FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept'AND  ProDate between ? AND ?  GROUP BY carton.JobNo ORDER BY CtnId1 asc";


            $PaginateQuery="SELECT Count(*) AS RowCount  , ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
            FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept'AND  ProDate between ? AND ?  GROUP BY carton.JobNo ORDER BY CtnId1 asc";

            $Param = [$From , $To]; 
        }
        else 
        {
            $Query="SELECT  CTNId, JobNo , ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType, ProDate 
            FROM `cartonproduction` 
            INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   
            INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept' GROUP BY carton.JobNo ORDER BY CtnId1 asc";

            $PaginateQuery="SELECT Count(*) AS RowCount  , ProductName,CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType, ProDate 
            FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept' GROUP BY carton.JobNo ORDER BY CtnId1 asc";


        }
        
    }
    else 
    {

        if (!empty($From) && !empty($To)) 
        {
            $Query="SELECT CTNId,  JobNo , ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
            FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept'   AND  ppcustomer.CustName=? AND  ProDate between ? AND ?  GROUP BY carton.JobNo ORDER BY CtnId1 asc";

            $PaginateQuery="SELECT Count(*) AS RowCount  ,  ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
            FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept'   AND  ppcustomer.CustName=? AND  ProDate between ? AND ?  GROUP BY carton.JobNo ORDER BY CtnId1 asc";


            $Param = [$_POST['CustomerName'] , $From , $To]; 
        }
        else 
        {
            $Query="SELECT CTNId,  JobNo , ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate   FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId 
            INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            where ProStatus='Accept'   and ppcustomer.CustName=? group by carton.JobNo order by CtnId1 asc";

            $PaginateQuery = "SELECT Count(*) AS RowCount  , ProductName,CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
            SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
            FROM `cartonproduction` INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
            WHERE ProStatus='Accept'  and ppcustomer.CustName=?  GROUP BY carton.JobNo ORDER BY CtnId1 asc" ; 
            
            $Param = [$_POST['CustomerName']  ]; 
        }
        
    }

}
else 
{
    $Query="SELECT CTNId,  JobNo , ProductName,CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
    SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
    FROM cartonproduction 
    INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   
    INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
    WHERE ProStatus='Accept' GROUP BY carton.JobNo ORDER BY CtnId1 asc";


    $PaginateQuery = "SELECT Count(*) AS RowCount  , ProductName, CONCAT(CTNLength ,'x',CTNWidth,'x',CTNHeight) AS Size, CTNType , CTNUnit , carton.CTNQTY,  `ProId`, `CtnId1`,  `CompId`,  
    SUM(ProQty) as prq,  SUM(ProOutQty) as prout , PrCtnType , ProDate 
    FROM `cartonproduction` 
    INNER JOIN ppcustomer ON ppcustomer.CustId=cartonproduction.CompId   
    INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 
    WHERE ProStatus='Accept' GROUP BY carton.JobNo ORDER BY CtnId1 asc" ; 
}


$Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
$DataRows = $Controller->QueryData($Query ,  $Param ); 


$RowCount =  $Controller->QueryData(   $PaginateQuery , $Param );
$pagination->records($RowCount->num_rows);
$pagination->records_per_page($RECORD_PER_PAGE);


// SELECT carton.CTNId,ppcustomer.CustName,CTNUnit, CONCAT(FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1)) AS Size ,CTNStatus,CTNQTY,CustId,CTNUnit,CTNType,
//     ProductName,CTNPaper,CTNColor,JobNo,Note,offesetp, cartonproduction.CtnId1, cartonproduction.ManagerApproval, 
//     cartonproduction.ProQty,cartonproduction.financeApproval,cartonproduction.financeAllowquantity,cartonproduction.ProOutQty,cartonproduction.ProStatus,cartonproduction.ProId, DesignImage, DesignCode1	 
//         FROM  carton 
//         INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
//         INNER JOIN designinfo ON designinfo.CaId=carton.CTNId
//         INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId 
//         INNER JOIN production_cycle ON cartonproduction.cycle_id = production_cycle.cycle_id  
//         WHERE production_cycle.cycle_status = "Completed"




?>


<style>
    [data-href] { cursor: pointer; }
</style>



<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) {    ?>
        <div class="alert alert-<?=$_GET['class']?>  alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_GET['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>

 

<div class="card m-3 shadow ">
    <div class="card-body  ">
        <h5 class = "my-0">   <svg width="45" height="45" viewBox="0 0 57 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M48.6544 39.472L36.8834 45.169L32.3364 35.774L44.1074 30.077L48.6544 39.472ZM45.8014 15.555L55.5234 35.644L49.6384 38.492L39.9154 18.404L45.8014 15.555ZM40.6184 46.767L56.9304 39.163L56.5494 37.56L38.8644 45.765C38.0264 45.494 37.1084 45.433 36.1894 45.655C36.0294 45.692 35.8724 45.739 35.7184 45.79L23.5754 22.832C25.0824 21.186 23.6874 17.597 20.7334 17.973C20.4424 18.01 20.3374 18.041 20.1304 18.06C17.3334 17.866 14.5304 16.943 11.9914 15.601C11.9754 15.307 11.9634 15.014 11.9464 14.72C11.7984 12.3 10.3914 10.167 7.75536 10.016C5.55036 9.89 2.90336 11.78 3.05136 14.207C3.40136 19.937 3.39736 21.341 3.37936 26.834L3.32236 26.832C3.35736 27.562 3.39136 28.772 3.42936 29.504C3.48436 30.64 3.88436 31.552 4.48236 32.239C4.48736 32.247 4.48836 32.259 4.49536 32.265C5.20236 33.352 5.14536 34.506 5.71036 35.668C4.66736 40.623 1.37936 45.574 0.105356 50.48C-0.828644 54.083 4.72936 55.607 5.66336 52.012C6.94736 47.071 10.8764 42.074 11.9294 37.078C11.9834 36.824 12.0024 36.58 11.9984 36.349C15.4584 39.924 17.7824 45.736 18.2194 50.812C18.5354 54.49 24.3014 54.518 23.9834 50.812C23.2544 42.344 18.9374 34.127 12.3124 29.035C12.2914 28.609 12.2714 28.181 12.2504 27.757L12.2724 27.759C12.2824 24.312 12.2904 25.471 12.2224 22.025C14.6074 22.938 17.1174 23.519 19.6354 23.712L19.6314 23.782C20.5254 23.775 21.0984 23.711 21.9814 23.599C22.1454 23.578 22.2884 23.536 22.4324 23.495L34.1934 46.646C32.7744 47.813 32.0544 49.722 32.5074 51.625C33.1384 54.287 35.8194 55.937 38.4844 55.307C41.1464 54.673 42.7964 51.993 42.1644 49.33C41.9184 48.298 41.3604 47.419 40.6184 46.767ZM37.7224 52.109C36.8244 52.322 35.9194 51.765 35.7064 50.869C35.4924 49.972 36.0504 49.065 36.9464 48.852C37.8424 48.638 38.7494 49.197 38.9624 50.093C39.1754 50.992 38.6204 51.895 37.7224 52.109ZM38.9304 19.382L43.4784 28.777L31.7074 34.474L27.1594 25.08L38.9304 19.382ZM7.66736 0C10.0594 0 11.9984 1.939 11.9984 4.331C11.9984 6.723 10.0594 8.662 7.66736 8.662C5.27536 8.662 3.33636 6.723 3.33636 4.331C3.33636 1.939 5.27536 0 7.66736 0Z" fill="#010002"/>
            </svg>
            Stock Balance
        </h5>
     <?php  echo (isset($_POST['CustomerName'])) ? '( '. $_POST['CustomerName'] .' )' :   "Customer" ; ?> Balance  
    </div>
</div>


<div class="card m-3 shadow ">
    <div class="card-body  ">
       
        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 my-1 pt-0 mt-0">
            <label for="name" class="fw-bold">Customer Name </label>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>"> 
                    <input list="CLInputDataList"  class="form-control" onkeyup="AJAXSearch(this.value)"  placeholder="Search Customer Names here " name = "CustomerName" id="CLInput">
                    <datalist id="CLInputDataList">
                    </datalist>
                  </form>
            </div>

            <div  class="col-lg-5 col-md-1 col-sm-1 col-xs-12 my-1"></div>

            <!-- <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 my-1">
                <form method="POST" action="CustomerCartonBalance.php">
                    <input type="hidden" name="CustomerName" value = "<?php //isset($_POST['CustomerName']) ? $_POST['CustomerName'] : 'ALL'; ?>" >
                <label class="form-label fw-bold" >From</label>
                <input type="date" class="form-control" name="From">
            </div>

            <div   class="col-lg-2 col-md-4 col-sm-4 col-xs-12 my-1">
                <label class="form-label fw-bold">To</label>
                <input type="date" class="form-control" name="To" onchange = "this.form.submit();"  >
                </form>
            </div>  -->

        </div>




    </div>
</div>




 





<div class="card m-3 shadow ">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="myTable">
                <thead class="fw-bold text-center table-info">
                    <tr>
                        <th class="text-start">Job No</th>
                        <th class="text-start">Description</th>
                        <th class="text-end">Order QTY</th>
                        <th class="text-end">Produced QTY</th>
                        <th class="text-end">Out QTY</th>
                        <th class="text-end">Remaining QTY</th>
                    </tr>
                </thead >
                <tbody class="fw-bold text-center">
                    <?php while($Rows = $DataRows->fetch_assoc()) : ?>
                        <tr onclick="window.location='CustomerCartonBalanceDetails.php?CTNId=<?=$Rows['CTNId'] ?>';" id = "tr_<?=$Rows['CTNId'] ?>" onmouseout = "resetDefault(this.id)" onmouseover = "ChangeColor(this.id); "  data-href >
                            <td class="text-start"> <?=$Rows['JobNo'] ?> </td>
                            <td class="text-start"><?= $Rows['ProductName']  . '('.$Rows['Size'].') - ' . $Rows['CTNType']  . 'ply - <span class="fw-bolder">' . $Rows['CTNUnit'] ."</span>"?></td>
                            <td class="text-end"><?= number_format($Rows['CTNQTY']) ?></td>
                            <td class="text-end"><?= number_format($Rows['prq']  ) ?></td>
                            <td class="text-end"><?=  number_format($Rows['prout']) ?></td>
                            <td class="text-end"><?=  number_format($Rows['prq'] - $Rows['prout'] )  ?></td>
                        </tr>
                    <?php endwhile;  ?>
                </tbody>             
            </table>
        </div>
    </div>
</div>


<div class = "d-flex justify-content-center mx-auto" > <?php  $pagination->render();  ?>    </div>

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

  function ChangeColor(id) {
    document.getElementById(id).style.color = 'blue';
    // document.getElementById(id).style.fontWeight = 'bold';
  }

  function resetDefault(id) {
    document.getElementById(id).style.color = 'black';
    // document.getElementById(id).style.fontWeight = '';
  }

</script>





<?php  require_once '../App/partials/Footer.inc'; ?>