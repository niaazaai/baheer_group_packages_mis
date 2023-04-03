<?php 
ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;


if(isset($_REQUEST['CTNId']))
{
    $CTNId=$_REQUEST['CTNId']; $ListType=$_REQUEST['ListType'];
    $SQL=$Controller->QueryData('SELECT carton.CTNId,ppcustomer.CustName,ProductQTY,CTNUnit, CONCAT(FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1)) AS Size ,CTNStatus,CTNQTY,CustId,
    ProductName,CTNPaper,FAQTY,CTNColor,JobNo,Note,offesetp, cartonproduction.CtnId1, cartonproduction.ManagerApproval, 
    cartonproduction.ProQty,cartonproduction.financeApproval,cartonproduction.financeAllowquantity,cartonproduction.ProOutQty,cartonproduction.ProStatus,cartonproduction.ProId 
     FROM  carton 
     INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1
     INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId 
     INNER JOIN production_cycle ON cartonproduction.cycle_id = production_cycle.cycle_id  
     WHERE  ManagerApproval="ManagerApproved" and  production_cycle.cycle_status = "Completed" AND production_cycle.CTNId=?  ', [$CTNId]);


}
else header('Location:index.php'); 
 
?>
 
<?php
      if(isset($_GET['MSG']) && !empty($_GET['MSG'])) 
      {
          $MSG=$_GET['MSG'];
          if($_GET['State']==1)
          {
              echo' <div class="alert alert-success alert-dismissible fade show m-3" role="alert"  id = "message">
                      <strong>Well Done!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
          elseif($_GET['State']==0)
          {
              echo' <div class="alert alert-warning alert-dismissible fade show m-3" role="alert" id = "message">
                      <strong>OPPS!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick = "remove_msg(`message`)" ></button>
                    </div>';
          }
      }
?>
 
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between   ">

      <div class = "my-1 p-0 m-0"> 
        <a class="btn btn-outline-primary btn-sm" href="JobCenter.php?ListType=<?=$ListType?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
        <span class = "fs-bold fs-3" >Finance Approval Page</span> 
      </div>
         
      <div class= "d-flex justify-content-end mt-1">
          <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2" style = "margin-top:10px;"  title="Click to Read the User Guide ">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
              </svg>
          </a>
      </div>

  </div>
</div>
 
<div class="card m-3 shadow">
    <div class="card-body">
      <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )"> 
            </div>
      </div>
    </div>                
 </div>

<div class="card m-3 shadow">
    <div class="card-body">
        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                    <th>#</th> 
                    <th>JobNo</th>
                    <th>Description</th> 
                    <th>O.QTY</th>
                    <th title="Produced QTY">P.QTY</th> 
                    <th>FAQ</th>
                    <th>Stock Out</th> 
                    <th title="Remaining Amount">Available</th>
                    <th>OPS</th>
                </tr>
            </thead>
            <tbody>
              <?php 
  
                  $COUNTER=1;$Count=1;
                  
                  while($Rows=$SQL->fetch_assoc())
                  {
                    $Remaining=$Rows['ProductQTY']-$Rows['ProOutQty'];
                    ?>
                        <tr>
                            <td><?=$Count?></td> 
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['ProductName'].' ( '.$Rows['Size'].' cm)'?></td>
                            <td><?=$Rows['CTNQTY']?></td>
                            <td><?=$Rows['ProductQTY']?></td> 
                            <td><?=$Rows['FAQTY']?></td>
                            <td><?=$Rows['ProOutQty']?></td> 
                            <td><?=$Remaining?></td>
                            <td>
                            <button class="btn btn-outline-primary btn-sm"  onclick = "PutQTYToModal(<?=$Rows['ProductQTY'] - $Rows['ProOutQty']?>,'<?=$Rows['CTNId']?>','<?=$Rows['ProId']?>' , <?=$Rows['ProOutQty']?> )" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Stock Out</button>
                                <!-- <button type="button" class = "btn btn-outline-primary btn-sm m-1 border-3" 
                                                    onclick = "PutQTYToModal(<?=$Rows['ProQty'] - $Rows['ProOutQty']?>,'<?=$Rows['CTNId']?>','<?=$Rows['ProId']?>' , <?=$Rows['ProOutQty']?> )" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> 
                                        STOCK OUT
                                </button>  -->
                            </td>
                        </tr>
                  <?php
                    $Count++;
                  }
              ?>
               
            </tbody>
        </table>  
    </div>
</div>
 
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Finance Approval</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    
        <form  id = "form_id" action="StoreStockOut.php" method = "post" onsubmit="return CheckQTY(event)" >  
            <input type="hidden" name="ListType" id = "ListType" value = "<?=$_REQUEST['ListType'];?>" >
            <input type="hidden" name="CTNID" id = "CTNID" value = "" >
            <input type="hidden" name="PROID" id = "PROID" value = "" >
            <input type="hidden" name="ListType" value="<?php if(isset($_POST['ListType'])){echo $_POST['ListType'];} ?>"> 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
                        <label>Available QTY</label>
                        <input type="text" name="QTY" id="QTY"   class="form-control mt-1" disabled>
                    </div><!-- END OF COL   -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="mt-2">OUT QTY</label>
                        <input type="text" name="minus" id="minus" class="form-control mt-1" value="<?=$Rows['ProOutQty']?>">
                    </div><!-- END OF COL   -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="submit" name="Save" id="Save" value="Save"  class="btn btn-outline-primary mt-3 text-end" >
                    </div>
                </div><!-- END OF ROW  --> 
                <!-- <button  class="btn btn-primary"  type="submit" name="SetColumns" >Stock Out</button> --> 
        </form>
  </div>
</div>

<script>
      function search(InputId ,tableId )
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

      
    function PutQTYToModal(QTY = 0,CTNId,ProId , outqty=0)
    {
        document.getElementById("QTY").value = QTY;        
        document.getElementById("CTNID").value = CTNId; 
        document.getElementById("PROID").value = ProId;
        document.getElementById("minus").value = outqty;
    }

    function CheckQTY(e)
    {
        e.preventDefault();
        var Qunatity = Number(document.getElementById("QTY").value);
        var minus = Number(document.getElementById("minus").value);

        console.log(typeof minus , typeof Qunatity); 

        if(minus > Qunatity)
        {
            console.log(minus , Qunatity); 
            alert("Can not Stockout More than Produced QTY");
            return false; 
        }
        document.getElementById("form_id").submit();
    }
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>
