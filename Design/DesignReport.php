
<?php require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';?>

<?php 
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE =45;
 
if(isset($_POST['From']) && isset($_POST['To']))
{
    $From=$_POST['From'];
    $To=$_POST['To'];
    echo $From."<br>".$To;

    $SQL='SELECT  `CTNId`,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, CTNType,`CTNStatus`, `CTNQTY`,`ProductName`,
    ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, offesetp,designinfo.CompleteTime,designinfo.DesignStatus, CURRENT_TIMESTAMP,
    designinfo.DesignCode1 ,designinfo.DesignerName1 ,designinfo.DesignStartTime,designinfo.CompleteTime , designinfo.DesignImage FROM `carton` INNER JOIN ppcustomer 
    ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId LEFT OUTER JOIN productionreport ON productionreport.RepCartonId=carton.CTNId  where  CTNOrderDate BETWEEN ? and ? ';
    
    $SQL .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';

    $DataRows=$Controller->QueryData($SQL,[$From,$To]);

    $PaginateQuery = 'SELECT  COUNT(CTNId) AS RowCount FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  where  CTNOrderDate BETWEEN "$From" and "$To"'; 
    $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
    $row = $RowCount->fetch_assoc(); 
    
    $pagination->records($RowCount->num_rows);
    $pagination->records_per_page($RECORD_PER_PAGE);

    $CUSTOMER_COUNT = $row['RowCount']; 


}
else
{
    $SQL='SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit,CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, CTNType,`CTNStatus`, `CTNQTY`,`ProductName`,
    ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, offesetp,	 designinfo.CompleteTime,designinfo.DesignStatus, CURRENT_TIMESTAMP,
    designinfo.DesignCode1 ,designinfo.DesignerName1 , DesignImage ,designinfo.DesignStartTime FROM `carton` INNER JOIN ppcustomer 
    ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId LEFT OUTER JOIN productionreport ON productionreport.RepCartonId=carton.CTNId';
    $SQL .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
    $DataRows=$Controller->QueryData($SQL,[]);

    $PaginateQuery = 'SELECT  COUNT(CTNId) AS RowCount FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId '; 
    $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
    $row = $RowCount->fetch_assoc(); 
    
    $pagination->records($RowCount->num_rows);
    $pagination->records_per_page($RECORD_PER_PAGE);
    $CUSTOMER_COUNT = $row['RowCount']; 

}

  

?>  



<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16">
            <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/>
            <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/>
            </svg>
            Report
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:5px;"  title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
	    </div><!-- Button trigger modal div end -->
    </div>
</div> 
 


<form action="" method="POST">
    <div class="card m-3 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="date" name="From" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="date" name="To" class="form-control" onchange="this.form.submit()">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="search">
                    <i class="fa-search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    </i>
                    <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                    </div>
                </div>
            </div>
        </div>                
    </div>
</form>
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">

      <table class= "table " id = "JobTable" >
          <thead>
              <tr class="table-info">
                  <th>#</th>
                  <th title="Quotation No">Q.No</th>
                  <th>JobNo</th>
                  <!-- <th title="Design Date">D.Date</th> -->
                  <th title="Company Name">C.Name</th> 
                  <th title="Product Name">P.Name</th>
                  <th>Size (LxWxH) cm</th>
                  <th>Color</th>
                  <th>Offset</th>
                  <!-- <th title="Product Type">P.Type</th> -->
                  <!-- <th title="Order QTY">O.QTY</th> -->
                  <th title="Design By">D.By</th>
                  <th>Design</th>
                  <th>Comment</th>
                  <th title="Time Take">T.Take</th>
              </tr>
          </thead>
          <tbody>
          <?php 
            $Count=1;
            while($Rows=$DataRows->fetch_assoc())
            {
          ?>
                <tr>
                <td><?=$Count?></td>
                <td><?=$Rows['CTNId']?></td>
                <td><?=$Rows['JobNo']?></td>
                <!-- <td><?=$Rows['CTNOrderDate']?></td> -->
                <td><?=$Rows['CustName']?></td>
                <td><?=$Rows['ProductName']?></td>
                <td><?=$Rows['Size']?></td>
                <td><?=$Rows['CTNColor']?></td>
                <td><?=$Rows['offesetp']?></td>
                <!-- <td><?=$Rows['CTNUnit'].", ".$Rows['CTNType']."Ply"?></td> -->
                <!-- <td><?=number_format($Rows['CTNQTY'])?></td> -->
                <td><?=$Rows['DesignerName1']?></td>


                <td class = " align-item-center    " >

              <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
              <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
              href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                  <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
              </a>
              <?php }  else {
                  echo '<span class = "text-danger" >N/A</span>';
              } ?>
              </td>


                <td><?=$Rows['Note']?></td>
                <td>
                  <?php 
                           $datetime1 = date_create($Rows['CompleteTime']);
                           $datetime2 = date_create($Rows['DesignStartTime']);
                           $interval = date_diff($datetime1 ,  $datetime2  );
                           echo  '<span class ="badge bg-info">' . $interval->format(' %a days | %h h | %i min') . '</span>';
                  ?>
                </td>
                </tr>
          <?php
              $Count++;
            }        
          ?> 
           </tbody> 
      </table>
   
  </div>

  <div class="card-body d-flex justify-content-between">
  <div class = "  my-2 ms-2 d-flex justify-content-between">
    Showing &nbsp;<span class = "fw-bold" ><?=$Count-1?> </span> &nbsp; of  &nbsp;<span class = "fw-bold" ><?= $CUSTOMER_COUNT; ?></span>
  </div>
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
